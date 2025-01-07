import { z, ZodType } from "zod";

export class UserSchema {
    static readonly LOGIN: ZodType = z.object({
        email: z.string().email().max(100),
        password: z.string().min(6).max(100),
    });

    static readonly REGISTER: ZodType = z
        .object({
            name: z.string().min(3).max(100),
            email: z.string().email().max(100),
            password: z.string().min(6),
            password_confirmation: z.string().min(6),
        })
        .superRefine((data, ctx) => {
            if (data.password !== data.password_confirmation) {
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    message: "Password and password confirmation must match",
                });
            }

            return data;
        });

    static readonly UPDATE: ZodType = z.object({
        phone: z
            .string()
            .nonempty("Nomer telepon harus dilengkapi")
            .regex(
                new RegExp(
                    /^([+]?[\s0-9]+)?(\d{3}|[(]?[0-9]+[)])?([-]?[\s]?[0-9])+$/
                ),
                {
                    message: "Phone number is not valid",
                }
            )
            .min(10, "Nomer telepon harus lebih dari 10 karakter")
            .max(15, "Nomer telepon harus kurang dari 15 karakter"),
        address: z
            .string()
            .nonempty("Alamat Harus dilengkapi")
            .min(15, "Alamat harus lebih dari 15 karakter"),
        name: z.string().min(3).max(100),
        email: z.string().email().max(100),
    });

    static readonly UPDATEPASSWORD: ZodType = z
        .object({
            current_password: z.string().min(6),
            password: z.string().min(6),
            password_confirmation: z.string().min(6),
        })
        .superRefine((data, ctx) => {
            if (data.password !== data.password_confirmation) {
                ctx.addIssue({
                    code: z.ZodIssueCode.custom,
                    message: "Password and password confirmation must match",
                });
            }

            return data;
        });
}
