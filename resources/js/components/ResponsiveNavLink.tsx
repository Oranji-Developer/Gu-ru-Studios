import { InertiaLinkProps, Link } from "@inertiajs/react";
import { cn } from "@/lib/utils";

export default function ResponsiveNavLink({
    active = false,
    className = "",
    children,
    ...props
}: InertiaLinkProps & { active?: boolean }) {
    return (
        <Link
            {...props}
            className={cn(
                "flex w-full items-center border-b py-2 pe-4 ps-3",
                active
                    ? "border-purple-400 bg-purple-50 text-primary focus:border-purple-700 focus:bg-purple-100 focus:text-purple-800"
                    : "border-transparent text-purple-300 hover:border-purple-300 hover:bg-purple-50 hover:text-primary focus:border-gray-300 focus:bg-gray-50 focus:text-gray-800",
                "text-base font-medium transition duration-150 ease-in-out focus:outline-none",
                className
            )}
        >
            {children}
        </Link>
    );
}
