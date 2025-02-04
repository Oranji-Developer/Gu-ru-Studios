import { z, ZodType } from "zod";

export class UserCourseSchema {
    static readonly UPDATE: ZodType = z.object({
        status: z.string().min(3).max(100),
    });
}
