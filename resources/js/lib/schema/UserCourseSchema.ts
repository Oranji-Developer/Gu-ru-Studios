import { z, ZodType } from "zod";

export class UserCourseSchema {
    static readonly CREATE: ZodType = z.object({
        children_id: z.number(),
        course_id: z.number(),
    });

    static readonly UPDATE: ZodType = z.object({
        status: z.string().min(3).max(100),
    });
}
