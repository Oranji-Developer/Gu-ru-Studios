import React from "react";
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
import { AnonLayout } from "./AnonLayout";
export const CustomerLayout = ({
    children,
}: {
    header?: React.ReactNode;
    children: React.ReactNode;
}) => {
    return (
        <AnonLayout
            navItems={
                <NavigationMenu>
                    <NavigationMenuList>
                        <NavigationMenuItem>
                            <NavLink
                                href={route("home")}
                                classActive="text-primary"
                                active={route().current("home")}
                            >
                                Home
                            </NavLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavLink
                                href={route("home")}
                                classActive="text-primary"
                                active={false}
                            >
                                Tentang Kami
                            </NavLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavLink
                                href={route("courses")}
                                classActive="text-primary"
                                active={route().current("courses")}
                            >
                                Layanan
                            </NavLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavLink
                                href={route("home")}
                                classActive="text-primary"
                                active={false}
                            >
                                Hubungi Kami
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
                        Home
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        href={route("profile.edit")}
                        active={
                            route().current("profile.edit") ||
                            route().current("account.edit")
                        }
                    >
                        Tentang Kami
                    </ResponsiveNavLink>
                </div>
            }
        >
            {children}
        </AnonLayout>
    );
};
