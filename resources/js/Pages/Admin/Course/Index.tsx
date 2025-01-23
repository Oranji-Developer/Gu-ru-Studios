import { AdminLayout } from "@/Layouts/AdminLayout";
import { Head, usePage, router } from "@inertiajs/react";
import { columns } from "./widgets/columns";
import { Course } from "@/types/Course";
import { DataTable } from "@/components/DataTable";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Label } from "@/components/ui/label";

import {
    MagnifyingGlassIcon,
    PlusIcon,
    AdjustmentsHorizontalIcon,
} from "@heroicons/react/24/solid";
import { useState } from "react";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import { Pagination } from "@/types/Pagination";

export default function Index() {
    const page = usePage().props;
    const status = page.statusFields as string[];
    const activeStatus = page.status as string;
    const courseType = page.course_type as string[];

    const courses = page.data as {
        data: Course[];
    } & Pagination;

    const [filter, setFilter] = useState(activeStatus);
    const [type, setType] = useState("");
    const [search, setSearch] = useState("");

    function searchCourse(search?: string, filter?: string, status?: string) {
        router.get(
            route("admin.course.index"),
            {
                search: search,
                filter: filter,
                status: status,
            },
            {
                preserveState: true,
                replace: true,
            }
        );
    }

    function resetFilter() {
        router.visit(route("admin.course.index"));
    }

    function filterStatus() {
        searchCourse(search, type, filter);
    }

    function selectType(type: string) {
        setType(type);
        setSearch("");
        searchCourse("", type);
    }

    return (
        <AdminLayout
            header={
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-2xl font-semibold leading-[1.8rem]">
                            Course
                        </h1>
                        <p className="text-sm leading-[1.05rem] text-gray-400">
                            Manage your course here.
                        </p>
                    </div>
                    <div>
                        <Button
                            onClick={() => {
                                router.visit(route("admin.course.create"));
                            }}
                        >
                            Add Course
                            <PlusIcon />
                        </Button>
                    </div>
                </div>
            }
        >
            <Head title="Course" />
            <section>
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
                        {courseType.map((element) => (
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
                        <div className="data-filter flex gap-2">
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
                                            searchCourse(search, type);
                                    }}
                                    className="pl-10 pr-4 py-2 rounded-full w-full"
                                />
                            </div>
                            <div className="dropdown-filter">
                                <Popover>
                                    <PopoverTrigger className="h-9 px-4 py-2 inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-full text-sm font-medium transition-colors border-primary text-primary *:focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border bg-background shadow-sm hover:bg-accent">
                                        <AdjustmentsHorizontalIcon className="h-5 w-5" />
                                        Filter
                                    </PopoverTrigger>
                                    <PopoverContent className="min-w-80 rounded-2xl py-3 border-gray-300">
                                        <div className="flex justify-between items-center mb-3">
                                            <h4 className="text-base">
                                                Filter
                                            </h4>
                                            <Button
                                                type="button"
                                                variant="link"
                                                className="hover:no-underline text-red-500"
                                                onClick={resetFilter}
                                            >
                                                Reset
                                            </Button>
                                        </div>
                                        <div className="space-y-3">
                                            <div className="space-y-1">
                                                <h4 className="text-sm">
                                                    Status
                                                </h4>
                                                <RadioGroup
                                                    value={filter}
                                                    defaultValue="male"
                                                    className="flex w-full gap-3"
                                                >
                                                    {status.map((element) => (
                                                        <div
                                                            key={element}
                                                            className={`rounded-full focus:border-primary flex items-center space-x-2 w-full border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground px-5 py-3 ${
                                                                filter ===
                                                                element
                                                                    ? "border-primary text-primary bg-primary-foreground"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <RadioGroupItem
                                                                onClick={() =>
                                                                    setFilter(
                                                                        element as any
                                                                    )
                                                                }
                                                                value={element}
                                                                id={element}
                                                            />
                                                            <Label
                                                                htmlFor={
                                                                    element
                                                                }
                                                                className="text-nowrap"
                                                            >
                                                                {element
                                                                    .charAt(0)
                                                                    .toUpperCase() +
                                                                    element.slice(
                                                                        1
                                                                    )}
                                                            </Label>
                                                        </div>
                                                    ))}
                                                </RadioGroup>
                                            </div>
                                            <Button
                                                type="button"
                                                className="w-full rounded-full"
                                                onClick={filterStatus}
                                            >
                                                Terapkan
                                            </Button>
                                        </div>
                                    </PopoverContent>
                                </Popover>
                            </div>
                        </div>
                    </div>
                </div>
                <DataTable
                    columns={columns}
                    from={courses.from}
                    to={courses.to}
                    data={courses.data}
                    firstPageUrl={courses.first_page_url}
                    lastPageUrl={courses.last_page_url}
                    links={courses.links}
                    total={courses.total}
                    per_page={courses.per_page}
                />
            </section>
        </AdminLayout>
    );
}
