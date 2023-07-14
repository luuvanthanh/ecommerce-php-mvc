<?php

class CategoryController extends BaseController
{
    private $categoryModel;

    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
    }

    public function index()
    {
        $selectColumns = ['id', 'name'];
        $orders = [
            'column' => 'id',
            'order' => 'desc'
        ];
        $categories = $this->categoryModel->getAll($selectColumns, $orders);

        return $this->view('frontend.categories.index', ['categories' => $categories]);
    }

    public function store()
    {
        $data = [
            'name' => 'Samm sung'
        ];

        $this->categoryModel->store($data);
    }

    public function show()
    {
        $id = $_GET['id'];
        $category = $this->categoryModel->findById($id);

        return $this->view('frontend.categories.detail', ['category' => $category]);
    }

    public function update()
    {
        $id = $_GET['id'];
        $data = [
            'name'  => 'Apples'
        ];
        $this->categoryModel->updateData($id, $data);
    }

    public function delete()
    {
        $id = $_GET['id'];
       
        $this->categoryModel->destroy($id);
    }
}
