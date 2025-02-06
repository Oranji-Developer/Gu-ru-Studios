import { ColumnDef } from "@tanstack/react-table";
import { Event } from "@/types/Event";
import { Button } from "@/components/ui/button";
import { router } from "@inertiajs/react";
import { PencilSquareIcon, TrashIcon } from "@heroicons/react/24/outline";
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

export const columns: ColumnDef<Event>[] = [
    {
        accessorKey: "title",
        header: "Nama Event",
    },
    {
        accessorKey: "disc",
        header: "Diskon",
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
                                route("admin.event.edit", { event: data.id })
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
                                            {data.title}
                                        </span>{" "}
                                        ?
                                    </p>
                                </AlertDialogTitle>
                                <AlertDialogDescription className="text-base">
                                    Apakah Anda yakin ingin menghapus{" "}
                                    <span className="text-red-500">
                                        {" "}
                                        {data.title}
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
                                            route("admin.event.destroy", {
                                                event: data.id,
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
