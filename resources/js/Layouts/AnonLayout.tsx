import { PropsWithChildren, ReactNode, useState } from "react";
import { Link, usePage } from "@inertiajs/react";

import ResponsiveNavLink from "@/components/ResponsiveNavLink";
import ApplicationLogo from "@/components/ApplicationLogo";
import { Footer } from "./widgets/Footer";
import { ChevronDownIcon } from "@heroicons/react/24/solid";
import { Toaster } from "@/components/ui/toaster";

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

import { Bars3Icon, XMarkIcon } from "@heroicons/react/24/solid";

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
            <nav className="relative">
                <div className="mx-auto max-w-8xl px-4 sm:px-6 lg:px-16 ">
                    <div className="flex h-[8rem] justify-between">
                        <div className="flex items-center">
                            <ApplicationLogo />
                        </div>
                        <div className="hidden sm:flex justify-between">
                            {navItems}
                        </div>

                        <div className="-me-2 flex items-center sm:hidden">
                            <Button
                                onClick={() =>
                                    setShowingNavigationDropdown(
                                        (previousState) => !previousState
                                    )
                                }
                            >
                                {showingNavigationDropdown ? (
                                    <XMarkIcon />
                                ) : (
                                    <Bars3Icon />
                                )}
                            </Button>
                        </div>
                        {!user && (
                            <div className="hidden md:flex items-center gap-2">
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
                            <div className="hidden md:flex items-center">
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
                    className={`
                        ${showingNavigationDropdown ? "absolute" : "hidden"}
                         sm:hidden inset-0 top-24 z-40  rounded-b-lg overflow-hidden ${
                             user ? "h-[25rem]" : "h-72"
                         }`}
                >
                    <div className="h-full bg-primary">
                        {navResponsiveItems}
                        {user && (
                            <div className="border-t border-gray-200 pb-1 pt-4">
                                <div className="px-4">
                                    <div className="text-base font-medium text-white">
                                        {user.name}
                                    </div>
                                    <div className="text-sm font-medium text-white/80">
                                        {user.email}
                                    </div>
                                </div>

                                <div className="mt-3 space-y-1">
                                    <ResponsiveNavLink
                                        href={route("dashboard")}
                                        as="button"
                                    >
                                        Kalas Saya
                                    </ResponsiveNavLink>
                                    <ResponsiveNavLink
                                        active={
                                            route().current("profile.edit") ||
                                            route().current("account.edit")
                                        }
                                        href={route("profile.edit")}
                                        as="button"
                                    >
                                        Settings
                                    </ResponsiveNavLink>
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
                        {!user && (
                            <div className="mt-3 space-y-1 bg-purple-950 border-t border-purple-800 pb-2">
                                <ResponsiveNavLink
                                    className="text-white"
                                    href={route("login")}
                                    as="button"
                                >
                                    Login
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    className="text-white"
                                    href={route("register")}
                                    as="button"
                                >
                                    Daftar Sekarang
                                </ResponsiveNavLink>
                            </div>
                        )}
                    </div>
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
