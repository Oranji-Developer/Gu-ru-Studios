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
                <div className="pb-3 pt-2">
                    <ResponsiveNavLink
                        className="justify-center"
                        href={route("dashboard")}
                        active={route().current("dashboard")}
                    >
                        Home
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        className="justify-center"
                        href={route("home")}
                        active={route().current("home")}
                    >
                        Tentang Kami
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        className="justify-center"
                        href={route("courses")}
                        active={route().current("courses")}
                    >
                        Layanan
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        className="justify-center"
                        href={route("home")}
                        active={false}
                    >
                        Hubungi Kami
                    </ResponsiveNavLink>
                </div>
            }
        >
            {children}
        </AnonLayout>
    );
};
