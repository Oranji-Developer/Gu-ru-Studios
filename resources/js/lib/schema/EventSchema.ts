import { title } from "process";
import { start } from "repl";
import { z, ZodType } from "zod";

export class EventSchema {
    static readonly CREATE: ZodType = z.object({
        title: z.string(),
        desc: z.string(),
        thumbnail: z.string(),
        disc: z.number(),
        course_type: z.string(),
        class: z.string(),
        start_date: z.string(),
        end_date: z.string(),
        status: z.string(),
    });

    static readonly UPDATE: ZodType = z.object({
        title: z.string().optional(),
        desc: z.string().optional(),
        thumbnail: z.string().optional(),
        disc: z.number().optional(),
        course_type: z.string().optional(),
        class: z.string().optional(),
        start_date: z.string().optional(),
        end_date: z.string().optional(),
        status: z.string().optional(),
    });
}
