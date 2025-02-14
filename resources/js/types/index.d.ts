import { User } from "@type/User";

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
