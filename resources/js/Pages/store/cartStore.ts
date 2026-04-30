import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

// Interface pour un produit tel qu'il est stocké dans le panier
interface CartProduct {
  id: number;
  title: string;
  price: number;
  unit: string;
  primary_image_url?: string;
  stock: number; // Quantité disponible en stock
}

// Interface pour un article dans le panier
interface CartItem {
  product: CartProduct;
  quantity: number;
}

export const useCartStore = defineStore('cart', () => {
  // État du panier, initialisé à partir du localStorage ou un tableau vide
  const cartItems = ref<CartItem[]>(JSON.parse(localStorage.getItem('cartItems') || '[]'));

  // Sauvegarde le panier dans le localStorage à chaque modification
  const saveCart = () => {
    localStorage.setItem('cartItems', JSON.stringify(cartItems.value));
  };

  // Actions
  const addItem = (product: CartProduct, quantity: number = 1) => {
    const existingItem = cartItems.value.find(item => item.product.id === product.id);

    if (existingItem) {
      const newQuantity = existingItem.quantity + quantity;

      if (newQuantity <= product.stock) {
        existingItem.quantity = newQuantity;
      } else {
        alert(`Impossible d'ajouter plus de ${product.title}. Stock disponible: ${product.stock}`);
        existingItem.quantity = product.stock; // Set to max available stock
      }
    } else {
      if (quantity <= product.stock) {
        cartItems.value.push({ product, quantity });
      } else {
        alert(`Impossible d'ajouter ${quantity} de ${product.title}. Stock disponible: ${product.stock}`);
        cartItems.value.push({ product, quantity: product.stock }); // Add with max available stock
      }
    }

    saveCart();
  };

  const removeItem = (productId: number) => {
    cartItems.value = cartItems.value.filter(item => item.product.id !== productId);
    saveCart();
  };

  const updateQuantity = (productId: number, newQuantity: number) => {
    const item = cartItems.value.find(item => item.product.id === productId);

    if (item) {
      if (newQuantity > 0 && newQuantity <= item.product.stock) {
        item.quantity = newQuantity;
      } else if (newQuantity <= 0) {
        removeItem(productId);
      } else {
        alert(`Impossible de définir la quantité à ${newQuantity} pour ${item.product.title}. Stock disponible: ${item.product.stock}`);
        item.quantity = item.product.stock;
      }

      saveCart();
    }
  };

  const clearCart = () => {
    cartItems.value = [];
    saveCart();
  };

  // Variables calculees
  const totalItems = computed(() => {
    return cartItems.value.reduce((total, item) => total + item.quantity, 0);
  });

  const totalPrice = computed(() => {
    return cartItems.value.reduce((total, item) => total + (item.product.price * item.quantity), 0);
  });

  return {
    cartItems,
    addItem,
    removeItem,
    updateQuantity,
    clearCart,
    totalItems,
    totalPrice,
  };
});
