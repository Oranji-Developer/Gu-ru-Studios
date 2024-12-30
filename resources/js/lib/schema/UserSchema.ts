import {z, ZodType} from "zod";

export class UserSchema {
    static readonly LOGIN: ZodType = z.object({
        email: z.string().email().max(100),
        password: z.string().min(6).max(100),
    });

    static readonly REGISTER: ZodType = z.object({
        name: z.string().min(3).max(100),
        email: z.string().email().max(100),
        address: z.string().min(3),
        phone: z.string().min(3).max(20),
        password: z.string().min(6),
        password_confirmation: z.string().min(6),
    }).superRefine(data => {
        if (data.password !== data.password_confirmation) {
            throw new Error('Password dan Konfirmasi Password tidak sama');
        }

        return data;
    });
}
