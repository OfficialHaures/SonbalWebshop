import { Product } from '@/types';

export function useStripe() {
  const createCheckoutSession = async (product: Product) => {
    const response = await fetch('/api/create-checkout-session', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ product }),
    });
    
    const { url } = await response.json();
    return url;
  };

  return { createCheckoutSession };
}
