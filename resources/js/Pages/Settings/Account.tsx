import React from "react";
import { PageProps } from "@/types";
import Setting from "./Setting";
import { Head } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import InputError from "@/components/InputError";
import { Settings } from "lucide-react";
import { FormEventHandler } from "react";
import { Link, useForm, usePage } from "@inertiajs/react";
import { router } from "@inertiajs/react";
import { UserSchema } from "@/lib/schema/UserSchema";
import { z } from "zod";
import InputPassword from "@/components/InputPassword";
import { Transition } from "@headlessui/react";

export default function Account({
    mustVerifyEmail,
    status,
}: PageProps<{ mustVerifyEmail: boolean; status?: string }>) {
    const user = usePage().props.auth.user;

    const { data, setData, put, errors, processing, recentlySuccessful } =
        useForm<z.infer<typeof UserSchema.UPDATEPASSWORD>>({
            email: user.email,
            current_password: "",
            password: "",
            password_confirmation: "",
        });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        const dataParse = UserSchema.UPDATEPASSWORD.safeParse(data);

        if (dataParse.success) {
            put(route("password.update"));
            data.reset();
        } else {
            console.log(dataParse.error.issues);
            for (const issue of dataParse.error.issues) {
                if (
                    errors[issue.path[0] as keyof typeof errors] === undefined
                ) {
                    errors[issue.path[0] as keyof typeof errors] =
                        issue.message;
                } else {
                    errors[issue.path[0] as keyof typeof errors] +=
                        ", " + issue.message;
                }
            }
            router.reload();
        }
    };

    return (
        <Setting>
            <Head title="Akun" />
            <div className="ps-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <header>
                        <h2 className="text-lg font-medium text-gray-900">
                            Informasi Akun
                        </h2>

                        <p className="mt-1 text-sm text-gray-600">
                            Disini kamu bisa ganti atau lihat tentang akun kamu.
                        </p>
                    </header>

                    <form onSubmit={submit}>
                        <div className="mb-8">
                            <Label htmlFor="email">Email</Label>
                            <Input
                                disabled={true}
                                id="email"
                                type="text"
                                className="mt-1 block w-full"
                                value={data.email}
                                onChange={(e) =>
                                    setData("name", e.target.value)
                                }
                            />
                            <InputError
                                className="mt-2"
                                message={errors.name}
                            />
                            <p className="text-sm text-gray-400 mt-1">
                                untuk email tidak bisa diganti ya!
                            </p>

                            {mustVerifyEmail &&
                                user.email_verified_at === null && (
                                    <div>
                                        <p className="mt-2 text-sm text-gray-800">
                                            Your email address is unverified.
                                            <Link
                                                href={route(
                                                    "verification.send"
                                                )}
                                                method="post"
                                                as="button"
                                                className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                            >
                                                Click here to re-send the
                                                verification email.
                                            </Link>
                                        </p>

                                        {status ===
                                            "verification-link-sent" && (
                                            <div className="mt-2 text-sm font-medium text-green-600">
                                                A new verification link has been
                                                sent to your email address.
                                            </div>
                                        )}
                                    </div>
                                )}
                        </div>

                        <div className="mb-3">
                            <InputPassword
                                id="current_password"
                                name="current_password"
                                label="Masukkan Password Saat Ini"
                                onChange={(e) =>
                                    setData("current_password", e.target.value)
                                }
                                value={data.current_password}
                                placeholder="Password Saat Ini"
                                error={errors.current_password}
                            />
                            <InputError
                                className="mt-2"
                                message={errors.current_password}
                            />
                        </div>

                        <div className="mb-3">
                            <InputPassword
                                id="password"
                                name="password"
                                label="Masukkan Password Baru"
                                onChange={(e) =>
                                    setData("password", e.target.value)
                                }
                                value={data.password}
                                placeholder="Password Baru"
                                error={errors.password}
                            />
                            <InputError
                                className="mt-2"
                                message={errors.password}
                            />
                        </div>

                        <div className="mb-4">
                            <InputPassword
                                id="password_confirmation"
                                name="password_confirmation"
                                label="Konfirmasi Password Baru"
                                onChange={(e) =>
                                    setData(
                                        "password_confirmation",
                                        e.target.value
                                    )
                                }
                                value={data.password_confirmation}
                                placeholder="Konfirmasi Password Baru"
                                error={errors.password_confirmation}
                            />
                            <InputError
                                className="mt-2"
                                message={errors.password_confirmation}
                            />

                            <p className="text-sm text-gray-400 mt-2">
                                Pastikan password tertulis dengan benar ya!
                            </p>
                        </div>

                        <div className="flex items-center gap-4">
                            <Button disabled={processing}>
                                Update Profile
                            </Button>

                            <Transition
                                show={recentlySuccessful}
                                enter="transition ease-in-out"
                                enterFrom="opacity-0"
                                leave="transition ease-in-out"
                                leaveTo="opacity-0"
                            >
                                <p className="text-sm text-gray-600">Saved.</p>
                            </Transition>
                        </div>

                        <div className="mt-4">
                            <Link href={route("logout")} method="post">
                                Logout
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </Setting>
    );
}
