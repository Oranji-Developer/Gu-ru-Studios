import { Mentor } from "@/types/model/Mentor";
import { Schedule } from "@/types/model/Schedule";

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
