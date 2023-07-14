<?php

class ProductController extends BaseController
{
    private $productModel;
    private $loadHelper;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
        $this->loadHelper = new Helper;
    }

    public function index()
    {
        $selectColumns = ['id', 'name'];
        $orders = [
            'column' => 'id',
            'order' => 'desc'
        ];
        $products = $this->productModel->getAll($selectColumns, $orders);

        return $this->view('frontend.products.index', ['products' => $products]);
    }

    public function store()
    {
        $data = [
            'name'        => 'Iphone 15',
            'price'       => 15000000,
            'image'       => null,
            'category_id' => 2
        ];

        $this->productModel->store($data);
    }

    public function show()
    {
        $id = $_GET['id'];
        $product = $this->productModel->findById($id);
        $product['price'] = $this->loadHelper->formatNumber($product['price']);
        
        return $this->view('frontend.products.show', ['product' => $product]);
    }

    public function update()
    {
        $id = $_GET['id'];
        $data = [
            'name'        => 'Iphone 21',
            'price'       => 15000000,
            'image'       => null,
            'category_id' => 2
        ];
        $this->productModel->updateData($id, $data);
    }

    public function delete()
    {
        $id = $_GET['id'];
       
        $this->productModel->destroy($id);
    }

    public function renderProductByCategoryId()
    {
        $categoryId = $_GET['id'];
        $data =  array_map(function($row) {
            $row['price'] = $this->loadHelper->formatNumber($row['price']);

            return $row;
        }, $this->productModel->getByCategoryId($categoryId));
        
        echo json_encode($data);
    }
}