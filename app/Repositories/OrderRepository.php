<?php

namespace App\Repositories;

use Log;
use App\Traits\CrudTrait;
use App\Models\ActiviteOrder;
 // Import the CrudTrait
use App\Interfaces\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderRepository implements OrderRepositoryInterface
{
    use CrudTrait; // Use the CrudTrait in your OrderRepository
    protected function getModel()
    {
        return new ActiviteOrder(); // Instantiate your actual Order model
    }
    public function getAllOrders()
    {
        $relation = [];
        return $this->getAllWithRelations($relation); // Use the trait's getAll method
    }

    public function getOrderById($orderId)
    {
        return $this->read($orderId); // Use the trait's read method
    }

    public function deleteOrder($orderId)
    {
        return $this->delete($orderId); // Use the trait's delete method
    }

    public function createOrder(array $orderDetails)
    {
        return $this->create($orderDetails); // Use the trait's create method
    }

    public function updateOrder($orderId, array $newDetails)
    {
        return $this->update($orderId, $newDetails); // Use the trait's update method
    }

    public function getFulfilledOrders()
    {
        return ActiviteOrder::where('is_fulfilled', true)->get(); // Custom implementation
    }

    // Other custom methods...

}
