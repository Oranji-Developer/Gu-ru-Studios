import { CustomerLayout } from "@/Layouts/CustomerLayout";
import { PageProps } from "@/types";
import { Head, Link, usePage } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { secondsInDay } from "date-fns/constants";
import { ArrowUpRightIcon } from "@heroicons/react/24/solid";
import { Hero } from "./widgets/Hero";
import { Supperior } from "./widgets/Supperior";
import { CourseSection } from "./widgets/CourseSection";

export default function Welcome({ auth }: PageProps) {
    const page = usePage();
    console.log(page.props);

    return (
        <CustomerLayout>
            <div className="flex flex-col gap-16">
                <Head title="Landing" />
                <Hero />
                <Supperior />
                <CourseSection />
            </div>
        </CustomerLayout>
    );
}
