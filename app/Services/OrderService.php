<?php

namespace App\Services;

use App\Enums\OrderDiscountTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
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
            $order->total = $this->calculateTotal($payload['discount'], $payload['discount_type'], $payload['products']);
            $order->description = $payload['description'] ?? null;
            $order->status = $payload['status'] ?? OrderStatusEnum::AWAITING_CONFIRMATION;
            $order->total_paid = $payload['total_paid'] ?? null;
            $order->is_paid = $payload['is_paid'] ?? false;
            $order->save();
            $order->orderProducts()->createMany($payload['products']);

            if (isset($payload['discount'])) {
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

    private function calculateTotal(float $discount, string $discountType, array $products): float
    {
        $total = collect($products)->sum(function ($product) {
            return $product['price'] * $product['quantity'];
        });

        if ($discountType === OrderDiscountTypeEnum::PERCENTAGE) {
            $discount = $total * ($discount / 100);
        }

        return $total - $discount;
    }

    public function update(array $payload, string $uuid)
    {
        try {
            DB::beginTransaction();

            $order = Order::where('uuid', $uuid)->with('orderDiscount')->with('orderProducts')->first();
            if (!$order) {
                throw new NotFoundHttpException;
            }

            $order->total = $this->calculateTotal($payload['discount'], $payload['discount_type'], $payload['products']);
            $order->fill($payload);

            if (isset($payload['products'])) {
                foreach ($payload['products'] as $index => $productData) {
                    if (!isset($order->orderProducts[$index])) {
                        $order->orderProducts()->create($productData);
                    } else {
                        $order->orderProducts[$index]->fill($productData);
                    }
                }
            }

            if (isset($payload['discount'])) {
                $order->orderDiscount->fill([
                    'discount_type' => $payload['discount_type'],
                    'discount' => $payload['discount']
                ]);
            }

            $order->save();

            DB::commit();

            return $order->refresh();
        } catch (NotFoundHttpException $e) {
            DB::rollBack();
            throw new NotFoundHttpException;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), 500);
        }
    }
}
