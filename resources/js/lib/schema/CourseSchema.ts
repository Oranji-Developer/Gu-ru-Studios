import { z, ZodType } from "zod";

export class CourseSchema {
    static readonly CREATE: ZodType = z
        .object({
            mentor_id: z.number(),
            title: z.string().min(5).max(100),
            desc: z.string().min(20),
            capacity: z.coerce.number().min(1),
            cost: z.coerce.number().min(1),
            disc: z.coerce.number().min(0).max(100),
            course_type: z.string().min(3).max(100),
            thumbnail: z.instanceof(File, {
                message: "Thumbnail must be an image file",
            }),
            class: z.string().min(5).optional(),
            status: z.string().min(3).max(100),
            start_time: z.string(),
            end_time: z.string(),
            start_date: z.date(),
            end_date: z.date(),
            day: z.array(z.string().max(7)),
            total_meet: z.number().min(1),
        })
        .superRefine((data, ctx) => {
            if (data.course_type !== "abk") {
                if (!data.class) {
                    ctx.addIssue({
                        code: z.ZodIssueCode.custom,
                        path: ["class"],
                        message: "class must be initialized",
                    });
                }
            }
        });

    static readonly UPDATE: ZodType = z
        .object({
            mentor_id: z.number(),
            title: z.string().min(5).max(100),
            desc: z.string().min(20),
            capacity: z.coerce.number().min(1),
            cost: z.coerce.number().min(1),
            disc: z.coerce.number().min(0).max(100),
            course_type: z.string().min(3).max(100),
            thumbnail: z
                .instanceof(File, {
                    message: "Thumbnail must be an image file",
                })
                .optional()
                .nullable(),
            class: z.string().min(4).optional(),
            status: z.string().min(3).max(100),
            start_time: z.string(),
            end_time: z.string(),
            start_date: z.date(),
            end_date: z.date(),
            day: z.array(z.string().max(7)),
            total_meet: z.number().min(1).optional(),
        })
        .superRefine((data, ctx) => {
            if (data.course_type !== "abk") {
                if (!data.class) {
                    ctx.addIssue({
                        code: z.ZodIssueCode.custom,
                        path: ["class"],
                        message: "class must be initialized",
                    });
                }
            }
        });
}
