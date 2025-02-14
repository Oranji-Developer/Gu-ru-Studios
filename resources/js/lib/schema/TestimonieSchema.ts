import { z, ZodType } from "zod";

export class TestimonieSchema {
    static readonly CREATE: ZodType = z.object({
        desc: z.string().min(20),
        rating: z.number().max(1),
    });

    static readonly UPDATE: ZodType = z.object({
        desc: z.string().min(20),
        rating: z.string().max(1),
    });
}
