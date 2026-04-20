export type User = {
    id: number;
    name: string;
    phone: string;
    email: string;
    role: string
    created_at: string;
    updated_at: string;
};

export type Auth = {
    user: {
        data: User;
    };

};
