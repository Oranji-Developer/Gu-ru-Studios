import { Mentor } from "@/types/Mentor";
import { Schedule } from "@/types/Schedule";

export type Course = {
    id: number;
    mentor_id: number;
    mentor: Mentor;
    schedule: Schedule;
    title: string;
    desc: string;
    capacity: number;
    cost: number;
    disc: number;
    course_type: string;
    class: string;
    thumbnail: string;
    status: string;
    created_at: string;
    updated_at: string;
};
