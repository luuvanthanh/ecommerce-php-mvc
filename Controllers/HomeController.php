
<?php

class HomeController extends BaseController
{
    private $categoryModel;
    private $productModel;
    private $loadHelper;

    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->loadModel('ProductModel');
        $this->categoryModel = new CategoryModel;
        $this->productModel = new ProductModel;
        $this->loadHelper = new Helper;
    }
    public function index()
    {
        $categories = $this->categoryModel->getAll();
        $products = $this->productModel->getAll();

        return $this->view('frontend.home.index',
        [
            'categories' => $categories,
            'products' => $products,
            'formatNumber' => $this->loadHelper
        ]);
    }
}
?>