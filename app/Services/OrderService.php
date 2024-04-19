<?php

namespace App\Services;

use App\Enums\OrderDiscountTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\OrderProduct;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class OrderService
{
    public function create(array $payload): Order
    {
        try {
            DB::beginTransaction();

            $order = new Order();
            $order->client_id = $payload['client_id'];
            $order->payment_type_id = $payload['payment_type_id'];
            $order->payment_date = $payload['payment_date'] ?? null;
            $order->payment_date = $payload['payment_date'] ?? null;
            $discount = $payload['discount'] ?? null;
            $discountType = $payload['discount_type'] ?? null;
            $order->total = $this->calculateTotal($payload['products'], $discount, $discountType);
            $order->description = $payload['description'] ?? null;
            $order->status = $payload['status'] ?? OrderStatusEnum::CONFIRMED;
            $order->total_paid = $payload['total_paid'] ?? null;
            $order->is_paid = $payload['is_paid'] ?? false;
            $order->save();
            $order->orderProducts()->createMany($payload['products']);

            if ($discount) {
                $order->orderDiscount()->create([
                    'discount_type' => $payload['discount_type'],
                    'discount' => $payload['discount']
                ]);
            }

            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 500);
        }
    }

    private function calculateTotal(array $products, float $discount = null, string $discountType = null): float
    {
        $total = collect($products)->sum(function ($product) {
            return $product['price'] * $product['quantity'];
        });

        if ($discount && $discountType) {
            if ($discountType === OrderDiscountTypeEnum::PERCENTAGE) {
                $discount = $total * ($discount / 100);
            }
            return $total - $discount;
        }

        return $total;
    }

    public function update(array $payload, string $uuid)
    {
        try {
            $order = Order::where('uuid', $uuid)->with('orderDiscount')->with('orderProducts')->first();
            if (!$order) {
                throw new NotFoundHttpException;
            }

            if (isset($payload['products'])) {
                $discount = $payload['discount'] ?? null;
                $discountType = $payload['discount_type'] ?? null;
                $order->total = $this->calculateTotal($payload['products'], $discount, $discountType);

                foreach ($payload['products'] as $index => $productData) {
                    if (!isset($order->orderProducts[$index])) {
                        $order->orderProducts()->create($productData);
                    } else {
                        $order->orderProducts[$index]->update([
                            'price' => $productData['price'],
                            'quantity' => $productData['quantity'],
                        ]);
                    }
                }
            }

            if (isset($payload['discount'])) {
                $order->orderDiscount->update([
                    'discount_type' => $payload['discount_type'],
                    'discount' => $payload['discount']
                ]);
            }

            $order->fill($payload);
            $order->save();

            return $order->refresh();
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }
}
