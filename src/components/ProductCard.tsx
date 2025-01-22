import { Product } from '@/types';
import { useStripe } from '@/hooks/useStripe';

interface Props {
  product: Product;
}

export default function ProductCard({ product }: Props) {
  const { createCheckoutSession } = useStripe();

  const handlePurchase = async () => {
    const url = await createCheckoutSession(product);
    window.location.href = url;
  };

  return (
    <div className="bg-white rounded-lg shadow-lg p-6">
      <h2 className="text-2xl font-bold mb-4">{product.name}</h2>
      <p className="text-gray-600 mb-4">{product.description}</p>
      <div className="space-y-2">
        <p>🎮 RAM: {product.ram}MB</p>
        <p>⚡ CPU: {product.cpu}%</p>
        <p>💾 Storage: {product.storage}MB</p>
        <p>🌐 Bandwidth: {product.bandwidth}GB</p>
      </div>
      <div className="mt-6">
        <p className="text-3xl font-bold">€{product.price}</p>
        <button
          onClick={handlePurchase}
          className="w-full mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition"
        >
          Purchase Now
        </button>
      </div>
    </div>
  );
}
