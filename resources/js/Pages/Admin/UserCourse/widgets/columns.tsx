"use client";

import { ColumnDef } from "@tanstack/react-table";
import { Button } from "@/components/ui/button";
import { router } from "@inertiajs/react";
import { TrashIcon, PencilSquareIcon } from "@heroicons/react/24/outline";
import { UserCourse } from "@/types/model/UserCourse";

export const columns: ColumnDef<UserCourse>[] = [
    {
        accessorKey: "content",
        header: "Content",
        cell: ({ row }) => {
            const data = row.original;
            return (
                <div className="flex gap-4 items-center px-2">
                    <img
                        className="w-28 h-16 object-cover rounded-lg"
                        src={"/storage/" + data.course.thumbnail}
                        alt={data.course.thumbnail}
                    />
                    <h4 className="text-base">{data.course.title}</h4>
                    <p>{data.course.desc}</p>
                </div>
            );
        },
    },
    {
        accessorKey: "children.name",
        header: "Ananda",
    },
    {
        accessorKey: "children.user.name",
        header: "Wali",
    },
    {
        header: "Waktu",
        cell: ({ row }) => {
            const startDate = row.original.start_date;
            const endDate = row.original.end_date;
            return (
                <p>
                    {startDate} - {endDate}
                </p>
            );
        },
    },
    {
        accessorKey: "status",
        header: "Status",
        cell(props) {
            const data = props.row.original;
            return (
                <div className="flex items-center gap-2">
                    <span
                        className={`p-1 rounded-full text-xs font-semibold text-white ${
                            data.status === "Selesai"
                                ? "bg-green-500"
                                : "bg-red-500"
                        }`}
                    ></span>
                    {data.status}
                </div>
            );
        },
    },
    {
        id: "actions",
        cell: ({ row }) => {
            const data = row.original;
            return (
                <div className="flex gap-2 justify-end px-4">
                    <Button
                        className="bg-transparent border border-gray-200 hover:border-primary hover:bg-primary/10 shadow-none rounded-full p-3 w-fit h-fit"
                        onClick={() => {
                            router.get(
                                route("admin.invoice.edit", {
                                    invoice: data.id,
                                })
                            );
                        }}
                        variant="secondary"
                    >
                        <PencilSquareIcon className="text-black" />
                    </Button>
                </div>
            );
        },
    },
];
