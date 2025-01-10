import React from "react";
import AuthenticatedLayout from "./AuthenticatedLayout";
import NavLink from "@/components/NavLink";
import ResponsiveNavLink from "@/components/ResponsiveNavLink";

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
export const AdminLayout = ({
    header,
    children,
}: {
    header?: React.ReactNode;
    children: React.ReactNode;
}) => {
    return (
        <AuthenticatedLayout
            header={header}
            navItems={
                <NavigationMenu>
                    <NavigationMenuList>
                        <NavigationMenuItem>
                            <NavLink
                                href={route("dashboard")}
                                active={route().current("dashboard")}
                            >
                                Dashboard
                            </NavLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavLink
                                href={route("admin.mentor.index")}
                                active={route().current("admin.mentor.index")}
                            >
                                Mentor
                            </NavLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavLink
                                href={route("profile.edit")}
                                active={
                                    route().current("profile.edit") ||
                                    route().current("account.edit")
                                }
                            >
                                Settings
                            </NavLink>
                        </NavigationMenuItem>
                    </NavigationMenuList>
                </NavigationMenu>
            }
            navResponsiveItems={
                <div className="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink
                        href={route("dashboard")}
                        active={route().current("dashboard")}
                    >
                        Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        href={route("profile.edit")}
                        active={
                            route().current("profile.edit") ||
                            route().current("account.edit")
                        }
                    >
                        Settings
                    </ResponsiveNavLink>
                </div>
            }
        >
            {children}
        </AuthenticatedLayout>
    );
};
