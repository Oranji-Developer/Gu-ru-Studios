import { InertiaLinkProps, Link } from "@inertiajs/react";

export default function NavLink({
    active = false,
    className = "",
    children,
    ...props
}: InertiaLinkProps & { active: boolean }) {
    return (
        <Link
            {...props}
            className={
                "inline-flex items-center px-1 pt-1 font-medium leading-5 transition duration-150 ease-in-out focus:outline-none " +
                (active
                    ? "text-gray-900"
                    : "text-gray-500  hover:text-gray-700 focus:text-gray-700") +
                className
            }
        >
            {children}
        </Link>
    );
}
