export interface User {
    id: number;
    name: string;
    address: string;
    phone: string;
    email: string;
    role: string;
    email_verified_at?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
    session: {
        flash: {
            success: string;
            error: string;
        };
    };
};
