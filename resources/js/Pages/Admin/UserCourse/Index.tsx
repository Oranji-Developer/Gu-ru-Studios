import { DataTable } from "@/components/DataTable";
import { AdminLayout } from "@/Layouts/AdminLayout";
import { Head, usePage, router } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { PlusIcon } from "@heroicons/react/24/solid";
import { columns } from "./widgets/columns";
import { UserCourse } from "@/types/UserCourse";
import React from "react";

export default function Index() {
    const page = usePage();
    const userCourses = page.props.data as {
        data: UserCourse[];
        current_page: number;
        first_page_url: string;
        last_page_url: string;
        links: {
            url: string;
            label: string;
            active: boolean;
        }[];
        from: number;
        to: number;
        total: number;
        per_page: number;
    };

    console.log(page.props);

    return (
        <AdminLayout
            header={
                <>
                    <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                        User Course
                    </h2>
                    <p className="text-sm leading-[1.05rem] text-gray-400">
                        Manage User Course
                    </p>
                </>
            }
        >
            <Head title="User Course" />
            <section>
                <DataTable
                    columns={columns}
                    from={userCourses.from}
                    to={userCourses.to}
                    data={userCourses.data}
                    firstPageUrl={userCourses.first_page_url}
                    lastPageUrl={userCourses.last_page_url}
                    links={userCourses.links}
                    total={userCourses.total}
                    per_page={userCourses.per_page}
                />
            </section>
        </AdminLayout>
    );
}
