import {
    ColumnDef,
    flexRender,
    getCoreRowModel,
    useReactTable,
} from "@tanstack/react-table";
import { Link, usePage } from "@inertiajs/react";

import { Button } from "@/components/ui/button";
import { router } from "@inertiajs/react";

import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";

interface DataTableProps<TData, TValue> {
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
    firstPageUrl?: string;
    lastPageUrl?: string;
    links?: {
        url?: string;
        label?: string;
        active?: boolean;
    }[];
    from: number;
    to: number;
    per_page: number;
    total: number;
}

export function DataTable<TData, TValue>({
    columns,
    data,
    links,
    total,
    firstPageUrl,
    lastPageUrl,
    per_page,
    from,
    to,
}: DataTableProps<TData, TValue>) {
    const table = useReactTable({
        data,
        columns,
        getCoreRowModel: getCoreRowModel(),
    });

    const path = window.location.href;

    function goTo(url: string) {
        if (url === path) return;
        router.visit(url);
    }

    return (
        <div className="">
            <div className="rounded-md border">
                <Table>
                    <TableHeader>
                        {table.getHeaderGroups().map((headerGroup) => (
                            <TableRow key={headerGroup.id}>
                                {headerGroup.headers.map((header) => {
                                    return (
                                        <TableHead key={header.id}>
                                            {header.isPlaceholder
                                                ? null
                                                : flexRender(
                                                      header.column.columnDef
                                                          .header,
                                                      header.getContext()
                                                  )}
                                        </TableHead>
                                    );
                                })}
                            </TableRow>
                        ))}
                    </TableHeader>
                    <TableBody>
                        {table.getRowModel().rows?.length ? (
                            table.getRowModel().rows.map((row) => (
                                <TableRow
                                    key={row.id}
                                    data-state={
                                        row.getIsSelected() && "selected"
                                    }
                                >
                                    {row.getVisibleCells().map((cell) => (
                                        <TableCell key={cell.id}>
                                            {flexRender(
                                                cell.column.columnDef.cell,
                                                cell.getContext()
                                            )}
                                        </TableCell>
                                    ))}
                                </TableRow>
                            ))
                        ) : (
                            <TableRow>
                                <TableCell
                                    colSpan={columns.length}
                                    className="h-24 text-center"
                                >
                                    No results.
                                </TableCell>
                            </TableRow>
                        )}
                    </TableBody>
                </Table>
            </div>
            <div className="flex justify-between items-center">
                <p className="ms-2 text-sm text-gray-400">
                    From <span className="text-black">{from}</span> to {to} of{" "}
                    {total} entries
                </p>
                <div className="flex items-center justify-end space-x-2 py-4">
                    {firstPageUrl && (
                        <Button
                            variant="outline"
                            size="sm"
                            onClick={() => goTo(firstPageUrl)}
                            disabled={
                                firstPageUrl === path ||
                                firstPageUrl === null ||
                                total <= per_page
                            }
                        >
                            &laquo;
                        </Button>
                    )}

                    {links?.map((link) => (
                        <Button
                            key={link.label}
                            variant="outline"
                            size="sm"
                            onClick={() => goTo(link.url ?? "")}
                            disabled={
                                link.url === path ||
                                link.url === null ||
                                link.active
                            }
                            className={link.active ? "bg-gray-200" : ""}
                        >
                            {link.label
                                ?.replace("&laquo;", "")
                                .replace("&raquo;", "")}
                        </Button>
                    ))}

                    {lastPageUrl && (
                        <Button
                            variant="outline"
                            size="sm"
                            onClick={() => goTo(lastPageUrl)}
                            disabled={
                                lastPageUrl === path ||
                                lastPageUrl === null ||
                                total <= per_page
                            }
                        >
                            &raquo;
                        </Button>
                    )}
                </div>
            </div>
        </div>
    );
}
