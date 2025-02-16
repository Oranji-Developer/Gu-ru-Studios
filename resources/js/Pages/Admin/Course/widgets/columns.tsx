"use client";

import { ColumnDef } from "@tanstack/react-table";
import { Button } from "@/components/ui/button";
import { router } from "@inertiajs/react";
import { Course } from "@/types/model/Course";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import {
    TrashIcon,
    PencilSquareIcon,
    ArrowTopRightOnSquareIcon,
} from "@heroicons/react/24/outline";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/components/ui/alert-dialog";

export const columns: ColumnDef<Course>[] = [
    {
        accessorKey: "content",
        header: "Content",
        cell: ({ row }) => {
            const data = row.original;
            return (
                <div className="flex gap-4 items-center px-2">
                    <img
                        className="w-28 h-16 object-cover rounded-lg"
                        src={"/storage/" + data.thumbnail}
                        alt={data.thumbnail}
                    />
                    <h4 className="text-base">{data.title}</h4>
                    <p>{data.desc}</p>
                </div>
            );
        },
    },
    {
        accessorKey: "mentor.name",
        header: "Mentor",
    },
    {
        accessorKey: "course_type",
        header: "Tipe",
    },
    {
        accessorKey: "user_course_count",
        header: "Pendaftar",
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
                            data.status === "Aktif"
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
                                route("admin.course.show", { course: data.id })
                            );
                        }}
                        variant="secondary"
                    >
                        <ArrowTopRightOnSquareIcon className="text-black" />
                    </Button>
                    <Button
                        className="bg-transparent border border-gray-200 hover:border-primary hover:bg-primary/10 shadow-none rounded-full p-3 w-fit h-fit"
                        onClick={() => {
                            router.get(
                                route("admin.course.edit", { course: data.id })
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
