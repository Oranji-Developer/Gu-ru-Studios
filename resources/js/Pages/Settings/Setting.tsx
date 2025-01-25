import { PropsWithChildren } from "react";
import NavLink from "@/components/NavLink";
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
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { usePage } from "@inertiajs/react";
import { AdminLayout } from "@/Layouts/AdminLayout";
import { CustomerLayout } from "@/Layouts/CustomerLayout";

export default function Setting({ children }: PropsWithChildren) {
    const user = usePage().props.auth.user;

    if (user.role === "admin") {
        return (
            <AdminLayout>
                <Element>{children}</Element>
            </AdminLayout>
        );
    } else if (user.role === "customer") {
        return (
            <CustomerLayout>
                <Element>{children}</Element>
            </CustomerLayout>
        );
    } else {
        return (
            <AuthenticatedLayout>
                <Element>{children}</Element>
            </AuthenticatedLayout>
        );
    }
}

const Element = ({ children }: PropsWithChildren) => {
    return (
        <section>
            <header className="border-b border-gray-200 pb-4">
                <h1 className="text-2xl font-semibold leading-[1.8rem]">
                    Settings
                </h1>
                <p className="text-sm leading-[1.05rem] text-gray-400">
                    Kelola pengaturan akun Anda dan atur preferensi email.
                </p>
            </header>

            <div className="pt-4 flex gap-4">
                <aside>
                    <NavigationMenu>
                        <NavigationMenuList className="flex-col gap-2 space-x-0 items-start">
                            <NavigationMenuItem className="">
                                <NavLink
                                    href={route("profile.edit")}
                                    active={route().current("profile.edit")}
                                >
                                    Profile
                                </NavLink>
                            </NavigationMenuItem>
                            <NavigationMenuItem>
                                <NavLink
                                    href={route("account.edit")}
                                    active={route().current("account.edit")}
                                >
                                    Akun
                                </NavLink>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </aside>
                <div className="grow">{children}</div>
            </div>
        </section>
    );
};
