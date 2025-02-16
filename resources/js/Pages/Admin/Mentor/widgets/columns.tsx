"use client";

import { ColumnDef } from "@tanstack/react-table";
import { Button } from "@/components/ui/button";
import { router } from "@inertiajs/react";
import { Mentor } from "@/types/model/Mentor";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { TrashIcon, PencilSquareIcon } from "@heroicons/react/24/outline";
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

// This type is used to define the shape of our data.
// You can use a Zod schema here if you want.

export const columns: ColumnDef<Mentor>[] = [
    {
        accessorKey: "name",
        header: "Nama",
        cell: ({ row }) => {
            const data = row.original;
            return (
                <div className="flex gap-4 items-center px-2">
                    <Avatar>
                        <AvatarImage src={"/storage/" + data.profile_picture} />
                        <AvatarFallback>
                            {data.name.split("", 2)}
                        </AvatarFallback>
                    </Avatar>
                    <h4 className="text-base">{data.name}</h4>
                </div>
            );
        },
    },
    {
        accessorKey: "phone",
        header: "Telepon",
    },
    {
        accessorKey: "field",
        header: "Tipe",
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
                                route("admin.mentor.edit", { mentor: data.id })
                            );
                        }}
                        variant="secondary"
                    >
                        <PencilSquareIcon className="text-black" />
                    </Button>
                    <AlertDialog>
                        <AlertDialogTrigger asChild>
                            <Button
                                className="bg-transparent border hover:bg-red-100 hover:border-red-400 border-gray-200 shadow-none rounded-full p-3 w-fit h-fit"
                                variant="destructive"
                            >
                                <TrashIcon className="text-red-500" />
                            </Button>
                        </AlertDialogTrigger>
                        <AlertDialogContent>
                            <AlertDialogHeader>
                                <AlertDialogTitle className="text-2xl">
                                    <div className="p-3 bg-red-50 w-fit rounded-full mb-3">
                                        <TrashIcon className="text-red-500 w-12 bg-red-100 p-2 rounded-full" />
                                    </div>
                                    <p>
                                        Menghapus{" "}
                                        <span className="text-red-500">
                                            {" "}
                                            {data.name}
                                        </span>{" "}
                                        ?
                                    </p>
                                </AlertDialogTitle>
                                <AlertDialogDescription className="text-base">
                                    Apakah Anda yakin ingin menghapus{" "}
                                    <span className="text-red-500">
                                        {" "}
                                        {data.name}
                                    </span>
                                    ? <br />
                                    <span className="font-medium text-sm">
                                        Aksi ini tidak dapat diurungkan.
                                    </span>
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter className="mt-4">
                                <AlertDialogCancel className="w-full">
                                    Batal
                                </AlertDialogCancel>
                                <AlertDialogAction
                                    className="bg-red-500 hover:bg-red-300 w-full"
                                    onClick={() => {
                                        router.delete(
                                            route("admin.mentor.destroy", {
                                                mentor: data.id,
                                            })
                                        );
                                    }}
                                >
                                    Ya, Hapus
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                </div>
            );
        },
    },
];
