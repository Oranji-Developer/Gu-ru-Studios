import { PropsWithChildren, ReactNode, useState } from "react";
import { Link, usePage } from "@inertiajs/react";

import ResponsiveNavLink from "@/components/ResponsiveNavLink";
import ApplicationLogo from "@/components/ApplicationLogo";
import { Footer } from "./widgets/Footer";
import { ChevronDownIcon } from "@heroicons/react/24/solid";
import { Toaster } from "@/components/ui/toaster";

import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuIndicator,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    NavigationMenuViewport,
} from "@/components/ui/navigation-menu";

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

import { Button } from "@/components/ui/button";
import { nullable } from "zod";

export const AnonLayout = ({
    children,
    navItems,
    navResponsiveItems,
}: PropsWithChildren<{
    navItems?: ReactNode;
    navResponsiveItems?: ReactNode;
}>) => {
    const user = usePage().props.auth.user;

    const [showingNavigationDropdown, setShowingNavigationDropdown] =
        useState(false);
    return (
        <div className="relative min-h-screen">
            <nav className="">
                <div className="mx-auto max-w-8xl px-4 sm:px-6 lg:px-16 ">
                    <div className="flex h-[8rem] justify-between">
                        <div className="flex items-center">
                            <ApplicationLogo />
                        </div>
                        <div className="hidden sm:flex justify-between">
                            {navItems}
                        </div>

                        <div className="-me-2 flex items-center sm:hidden">
                            <button
                                onClick={() =>
                                    setShowingNavigationDropdown(
                                        (previousState) => !previousState
                                    )
                                }
                                className="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    className="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        className={
                                            !showingNavigationDropdown
                                                ? "inline-flex"
                                                : "hidden"
                                        }
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        className={
                                            showingNavigationDropdown
                                                ? "inline-flex"
                                                : "hidden"
                                        }
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                        {!user && (
                            <div className="flex items-center gap-2">
                                <Button
                                    type="button"
                                    variant="secondary"
                                    className="bg-white"
                                >
                                    <Link href={route("login")}>Login</Link>
                                </Button>
                                <Button type="button">
                                    <Link href={route("register")}>
                                        Daftar Sekarang
                                    </Link>
                                </Button>
                            </div>
                        )}
                        {user && (
                            <div className="flex items-center">
                                <DropdownMenu>
                                    <DropdownMenuTrigger>
                                        <Button asChild={true}>
                                            <h1>
                                                {user.name.length > 5
                                                    ? user.name.slice(0, 5)
                                                    : user.name}
                                                <ChevronDownIcon />
                                            </h1>
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent className="min-w-48">
                                        <DropdownMenuLabel>
                                            <h3>{user.name}</h3>
                                            <h5 className="text-sm font-normal text-gray-600">
                                                {user.email}
                                            </h5>
                                        </DropdownMenuLabel>
                                        <DropdownMenuSeparator />
                                        {user.role === "admin" ? (
                                            <DropdownMenuItem>
                                                <Link
                                                    href={route("dashboard")}
                                                    className="w-full"
                                                >
                                                    Dashboard
                                                </Link>
                                            </DropdownMenuItem>
                                        ) : (
                                            <DropdownMenuItem>
                                                <Link
                                                    href={route(
                                                        "user.course.index"
                                                    )}
                                                    className="w-full"
                                                >
                                                    Kelas Saya
                                                </Link>
                                            </DropdownMenuItem>
                                        )}
                                        <DropdownMenuItem>
                                            <Link
                                                href={route("profile.edit")}
                                                className="w-full"
                                            >
                                                Settings
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem>
                                            <Link
                                                href={route("logout")}
                                                method="post"
                                                className="text-red-500 w-full text-start"
                                            >
                                                Logout
                                            </Link>
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        )}
                    </div>
                </div>

                <div
                    className={
                        (showingNavigationDropdown ? "block" : "hidden") +
                        " sm:hidden"
                    }
                >
                    {navResponsiveItems}
                    {user && (
                        <div className="border-t border-gray-200 pb-1 pt-4">
                            <div className="px-4">
                                <div className="text-base font-medium text-gray-800">
                                    {user.name}
                                </div>
                                <div className="text-sm font-medium text-gray-500">
                                    {user.email}
                                </div>
                            </div>

                            <div className="mt-3 space-y-1">
                                <ResponsiveNavLink
                                    method="post"
                                    href={route("logout")}
                                    as="button"
                                >
                                    Log Out
                                </ResponsiveNavLink>
                            </div>
                        </div>
                    )}
                </div>
            </nav>

            <main className="mx-auto max-w-8xl px-4 sm:px-6 lg:px-16 pt-6 min-h-[calc(75vh-24.9rem)]">
                {children}
            </main>
            <Footer />
            <Toaster />
        </div>
    );
};
