import { Head, router, usePage } from "@inertiajs/react";
import { AdminLayout } from "@/Layouts/AdminLayout";
import { Mentor } from "@/types/Mentor";
import { columns } from "./widgets/columns";
import { DataTable } from "./widgets/data-table";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { MagnifyingGlassIcon, PlusIcon } from "@heroicons/react/24/solid";
import { useState } from "react";

export default function Index() {
    const page = usePage();
    const fields = page.props.fields as string[];
    const mentors = page.props.mentors as {
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
    const [type, setType] = useState("");

    function searchMentor(search?: string, filter?: string) {
        router.get(
            route("admin.mentor.index"),
            {
                filter: filter,
                search: search,
            },
            {
                preserveState: true,
                replace: true,
            }
        );
    }

    function selectType(type: string) {
        setType(type);
        setSearch("");
        searchMentor("", type);
    }

    return (
        <AdminLayout
            header={
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-2xl font-semibold leading-[1.8rem]">
                            Mentor
                        </h1>
                        <p className="text-sm leading-[1.05rem] text-gray-400">
                            Manage your mentor here.
                        </p>
                    </div>
                    <div className="">
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
            }
        >
            <section>
                <Head title="Mentor" />

                <div className="flex justify-between items-center mb-2">
                    <div className="bg-gray-100 p-1 rounded-md inline-flex gap-1">
                        <Button
                            key="all"
                            variant={!type ? "default" : "ghost"}
                            type="button"
                            className={`${!type ? "" : ""}`}
                            onClick={() => selectType("")}
                        >
                            Semua
                        </Button>
                        {fields.map((element) => (
                            <Button
                                key={element}
                                variant={element === type ? "default" : "ghost"}
                                className={`${
                                    element === type
                                        ? ""
                                        : "hover:text-gray-500"
                                }`}
                                type="button"
                                onClick={() => {
                                    selectType(element);
                                }}
                            >
                                {element}
                            </Button>
                        ))}
                    </div>
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
                                    if (e.key === "Enter")
                                        searchMentor(search, type);
                                }}
                                className="pl-10 pr-4 py-2 rounded-full w-full"
                            />
                        </div>
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
