import { DataTable } from "@/components/DataTable";
import { AdminLayout } from "@/Layouts/AdminLayout";
import { Head, usePage, router } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { PlusIcon } from "@heroicons/react/24/solid";
import { columns } from "./widgets/columns";
import { UserCourse } from "@/types/UserCourse";
import { useState } from "react";
import { Input } from "@/components/ui/input";
import { MagnifyingGlassIcon } from "@heroicons/react/24/solid";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Label } from "@/components/ui/label";
import { AdjustmentsHorizontalIcon } from "@heroicons/react/24/outline";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";

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

    const statusFields = page.props.statusFields as string[];
    const timeFields = page.props.timeFields as string[];

    console.log(page.props);
    const [filter, setFilter] = useState();

    const [search, setSearch] = useState("");
    const [status, setStatus] = useState("");

    function searchUserCourse(search?: string, filter?: string) {
        router.get(
            route("admin.invoice.index"),
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

    function resetFilter() {
        router.visit(route("admin.invoice.index"));
    }

    function selectStatus(type: string) {
        setStatus(type);
        setSearch("");
        searchUserCourse("", type);
    }

    function filterStatus() {
        router.get(
            route("admin.invoice.index"),
            {
                time: filter,
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
                <div className="flex justify-between items-center mb-2">
                    <div className="bg-gray-100 p-1 rounded-md inline-flex gap-1">
                        <Button
                            key="all"
                            variant={!status ? "default" : "ghost"}
                            type="button"
                            className={`${!status ? "" : ""}`}
                            onClick={() => selectStatus("")}
                        >
                            Semua
                        </Button>
                        {statusFields.map((element) => (
                            <Button
                                key={element}
                                variant={
                                    element === status ? "default" : "ghost"
                                }
                                className={`${
                                    element === status
                                        ? ""
                                        : "hover:text-gray-500"
                                }`}
                                type="button"
                                onClick={() => {
                                    selectStatus(element);
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
                                            searchUserCourse(search, status);
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
                                                    {timeFields.map(
                                                        (element) => (
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
                                                                    value={
                                                                        element
                                                                    }
                                                                    id={element}
                                                                />
                                                                <Label
                                                                    htmlFor={
                                                                        element
                                                                    }
                                                                    className="text-nowrap"
                                                                >
                                                                    {element
                                                                        .charAt(
                                                                            0
                                                                        )
                                                                        .toUpperCase() +
                                                                        element.slice(
                                                                            1
                                                                        )}
                                                                </Label>
                                                            </div>
                                                        )
                                                    )}
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
