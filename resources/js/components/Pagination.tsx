import React from "react";

import { Button } from "@/components/ui/button";
import { router } from "@inertiajs/react";

interface PaginationProps {
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

export const Pagination: React.FC<PaginationProps> = ({
    firstPageUrl,
    lastPageUrl,
    links,
    from,
    to,
    per_page,
    total,
}) => {
    const path = window.location.href;
    function goTo(url: string) {
        if (url === path) return;
        router.visit(url);
    }
    return (
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
    );
};
