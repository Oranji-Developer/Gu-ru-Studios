import { Children } from "./Children";
import { Course } from "./Course";

export type UserCourse = {
    id: number;
    children_id: number;
    children: Children;
    course_id: number;
    course: Course;
    report: string;
    start_date: string;
    end_date: string;
    status: string;
    created_at: string;
    updated_at: string;
};
