import { z, ZodType } from "zod";

export class ChildrenSchema {
    static readonly CREATE: ZodType = z.object({
        name: z.string().min(3),
        class: z.number().int().positive(),
        gender: z.string().min(4),
    });
}
