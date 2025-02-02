import React from "react";
import { CustomerLayout } from "@/Layouts/CustomerLayout";
import { CourseSection } from "../Landing/widgets/CourseSection";

export default function Index() {
    return (
        <CustomerLayout>
            <CourseSection />
        </CustomerLayout>
    );
}
