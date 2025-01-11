import { z, ZodType } from "zod";

export class MentorSchema {
    static readonly CREATE: ZodType = z.object({
        name: z.string().min(3).max(100),
        address: z.string().min(20),
        desc: z.string().min(20),
        gender: z.string().min(1),
        field: z.string().min(3).max(100),
        profile_picture: z.instanceof(File, {
            message: "Profile picture must be an image file",
        }),
        cv: z.instanceof(File, {
            message: "CV must be a file",
        }),
        portfolio: z.instanceof(File, {
            message: "Portofolio must be a file",
        }),
        phone: z.string(),
        youtube: z.string().optional(),
    });

    static readonly UPDATE: ZodType = z.object({
        name: z.string().min(3).max(100),
        address: z.string().min(20),
        desc: z.string().min(20),
        gender: z.string().min(1),
        field: z.string().min(3).max(100),
        profile_picture: z
            .instanceof(File, {
                message: "Profile picture must be an image file",
            })
            .optional()
            .nullable(),
        cv: z
            .instanceof(File, {
                message: "CV must be a file",
            })
            .optional()
            .nullable(),
        portfolio: z
            .instanceof(File, {
                message: "Portofolio must be a file",
            })
            .optional()
            .nullable(),
        phone: z.string(),
        youtube: z.string().optional(),
    });
}
