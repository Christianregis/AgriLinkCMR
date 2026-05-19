export interface Message {
    id: number;
    conversation_id: number;
    sender_id: number;
    body: string;
    attachment_path?: string;
    read_at?: string;
    created_at: string;
}

export interface Farmer {
    id: number;
    name: string;
    profile_photo: string;
}

export interface Buyer {
    id: number;
    name: string;
    profile_photo: string;
}

export interface Product {
    id: number;
    title: string;
    primary_image: string;
    price?: number;
}

export interface Conversation {
    id: number;
    farmer_id: number;
    buyer_id: number;
    product_id?: number | null;
    last_message_at?: string | null;
    is_archived: boolean;
    created_at: string;
    updated_at: string;

    farmer: Farmer;
    buyer: Buyer;
    product: Product;

    messages: Message[];

    last_message?: string;
    unread_count?: number;
}
