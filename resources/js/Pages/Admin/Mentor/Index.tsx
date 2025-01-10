import { Head } from "@inertiajs/react";
import { AdminLayout } from "@/Layouts/AdminLayout";

import React from "react";

export default function Index() {
    return (
        <AdminLayout>
            <section>
                <Head title="Mentor" />
                <h1 className="text-2xl font-semibold leading-[1.8rem]">
                    Mentor
                </h1>
                <p className="text-sm leading-[1.05rem] text-gray-400">
                    Manage your mentor here.
                </p>
            </section>
        </AdminLayout>
    );
}
