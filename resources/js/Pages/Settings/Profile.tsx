import { PageProps } from "@/types";
import { Head } from "@inertiajs/react";
import Setting from "./Setting";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import InputError from "@/components/InputError";

import { Transition } from "@headlessui/react";
import { Link, useForm, usePage } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { UserSchema } from "@/lib/schema/UserSchema";
import { z } from "zod";
import { router } from "@inertiajs/react";

export default function Profile({
    mustVerifyEmail,
    status,
}: PageProps<{ mustVerifyEmail: boolean; status?: string }>) {
    const user = usePage().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful } =
        useForm<z.infer<typeof UserSchema.UPDATE>>({
            name: user.name,
            address: user.address,
            email: user.email,
            phone: user.phone,
        });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        const dataParse = UserSchema.UPDATE.safeParse(data);

        if (dataParse.success) {
            patch(route("profile.update"));
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
            <Head title="Profile" />

            <div className="ps-12">
                <div className="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <header>
                        <h2 className="text-lg font-medium text-gray-900">
                            Informasi Profil
                        </h2>

                        <p className="mt-1 text-sm text-gray-600">
                            Dengan cara inilah orang lain akan melihat Anda di
                            situs.
                        </p>
                    </header>

                    <form onSubmit={submit} className="mt-6 space-y-6">
                        <div>
                            <Label htmlFor="name">Nama</Label>
                            <Input
                                className="mt-1"
                                id="name"
                                name="name"
                                value={data.name}
                                placeholder="name"
                                autoComplete="name"
                                onChange={(e) =>
                                    setData("name", e.target.value)
                                }
                            />

                            <InputError
                                className="mt-2"
                                message={errors.name}
                            />
                        </div>

                        <div>
                            <Label htmlFor="address">Alamat</Label>
                            <Input
                                className="mt-1"
                                id="address"
                                name="address"
                                value={data.address}
                                placeholder="address"
                                autoComplete="address"
                                onChange={(e) =>
                                    setData("address", e.target.value)
                                }
                            />

                            <InputError
                                className="mt-2"
                                message={errors.address}
                            />
                        </div>

                        <div>
                            <Label htmlFor="name">Phone</Label>
                            <Input
                                className="mt-1"
                                id="phone"
                                name="phone"
                                value={data.phone}
                                placeholder="phone"
                                autoComplete="phone"
                                onChange={(e) =>
                                    setData("phone", e.target.value)
                                }
                            />

                            <InputError
                                className="mt-2"
                                message={errors.phone}
                            />
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
                    </form>
                </div>
            </div>
        </Setting>
    );
}
