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

export default function Setting({ children }: PropsWithChildren) {
    return (
        <AuthenticatedLayout>
            <main className="mx-auto max-w-8xl px-4 sm:px-6 lg:px-16 pt-6">
                <header className="border-b border-gray-200 pb-4">
                    <h1 className="text-2xl font-semibold leading-[1.8rem]">
                        Settings
                    </h1>
                    <p className="text-sm leading-[1.05rem] text-gray-400">
                        Kelola pengaturan akun Anda dan atur preferensi email.
                    </p>
                </header>

                <section className="pt-4 flex gap-4">
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
                </section>
            </main>
        </AuthenticatedLayout>
    );
}
