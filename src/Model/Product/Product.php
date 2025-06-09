<?php

declare(strict_types=1);

namespace App\Model\Product;

use App\Model\Category\Category;
use App\Model\Attribute\Attribute;
use App\Model\Price\Price;

abstract class Product
{
    protected string $id;
    protected string $name;
    protected bool $inStock;
    protected array $gallery;
    protected string $description;
    protected string $brand;
    protected array $prices = [];
    protected array $attributes = [];
    protected Category $category;

    public function __construct(
        string $id,
        string $name,
        bool $inStock,
        array $gallery,
        string $description,
        string $brand,
        array $prices,
        array $attributes,
        Category $category
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->gallery = $gallery;
        $this->description = $description;
        $this->brand = $brand;
        $this->prices = $prices;
        $this->attributes = $attributes;
        $this->category = $category;
    }

    public function getId(): string { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getInStock(): bool { return $this->inStock; }
    public function getGallery(): array { return $this->gallery; }
    public function getDescription(): string { return $this->description; }
    public function getBrand(): string { return $this->brand; }
    public function getPrices(): array { return $this->prices; }
    public function getAttributes(): array { return $this->attributes; }
    public function getCategory(): Category { return $this->category; }

    public function addAttribute(Attribute $attribute): void
    {
        $this->attributes[] = $attribute;
    }
    
    public function addPrice(Price $price): void
    {
        $this->prices[] = $price;
    }
}