'use client';
import { useState } from 'react';
import ProductCard from '@/components/ProductCard';
import { Product } from '@/types';

const products: Product[] = [
  {
    id: '1',
    name: 'Starter Package',
    description: 'Perfect for small projects',
    price: 9.99,
    ram: 2048,
    cpu: 100,
    storage: 20480,
    bandwidth: 1000,
  },
  // Add more products here
];

export default function Home() {
  return (
    <main className="min-h-screen p-8">
      <h1 className="text-4xl font-bold text-center mb-12">
        Hosting Solutions
      </h1>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
        {products.map((product) => (
          <ProductCard key={product.id} product={product} />
        ))}
      </div>
    </main>
  );
}
