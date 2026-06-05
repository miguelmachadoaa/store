<?php 

class OrderPlaced
{
    use Dispatchable, SerializesModels;
    public function __construct(public Order $order) {}
}