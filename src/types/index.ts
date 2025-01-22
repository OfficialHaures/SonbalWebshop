export interface Product {
  id: string;
  name: string;
  description: string;
  price: number;
  ram: number;
  cpu: number;
  storage: number;
  bandwidth: number;
}

export interface Order {
  id: string;
  userId: string;
  productId: string;
  status: 'pending' | 'completed' | 'failed';
  serverId?: string;
}
