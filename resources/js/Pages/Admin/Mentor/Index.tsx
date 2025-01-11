import { Head, router, usePage } from "@inertiajs/react";
import { AdminLayout } from "@/Layouts/AdminLayout";
import { columns, Mentor } from "./widgets/columns";
import { DataTable } from "./widgets/data-table";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { MagnifyingGlassIcon, PlusIcon } from "@heroicons/react/24/solid";
import { useState } from "react";

export default function Index() {
    const mentors = usePage().props.mentors as {
        data: Mentor[];
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

    const [search, setSearch] = useState("");

    function searchMentor() {
        router.get(
            route("admin.mentor.index"),
            {
                search: search,
            },
            {
                preserveState: true,
                replace: true,
            }
        );
    }

    return (
        <AdminLayout
            header={
                <div>
                    <h1 className="text-2xl font-semibold leading-[1.8rem]">
                        Mentor
                    </h1>
                    <p className="text-sm leading-[1.05rem] text-gray-400">
                        Manage your mentor here.
                    </p>
                </div>
            }
        >
            <section>
                <Head title="Mentor" />

                <div className="flex justify-between items-center mb-2">
                    <div className=""></div>
                    <div className="flex gap-4">
                        <div className="relative flex-grow">
                            <MagnifyingGlassIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                            <Input
                                type="text"
                                placeholder="Search..."
                                value={search}
                                onChange={(e) => {
                                    setSearch(e.target.value);
                                    if (search === "") router.reload();
                                }}
                                onKeyDown={(e) => {
                                    if (e.key === "Enter") searchMentor();
                                }}
                                className="pl-10 pr-4 py-2 rounded-full w-full"
                            />
                        </div>
                        <Button
                            onClick={() => {
                                router.visit(route("admin.mentor.create"));
                            }}
                        >
                            Add Mentor
                            <PlusIcon />
                        </Button>
                    </div>
                </div>
                <DataTable
                    columns={columns}
                    from={mentors.from}
                    to={mentors.to}
                    data={mentors.data}
                    firstPageUrl={mentors.first_page_url}
                    lastPageUrl={mentors.last_page_url}
                    links={mentors.links}
                    total={mentors.total}
                    per_page={mentors.per_page}
                />
            </section>
        </AdminLayout>
    );
}
