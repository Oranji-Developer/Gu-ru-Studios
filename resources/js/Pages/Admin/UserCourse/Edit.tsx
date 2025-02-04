import React from "react";
import { AdminLayout } from "@/Layouts/AdminLayout";
import { UserCourse } from "@/types/UserCourse";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { Label } from "@/components/ui/label";
import { UserCourseSchema } from "@/lib/schema/UserCourseSchema";
import { zodResolver } from "@hookform/resolvers/zod";
import { Head, useForm, usePage, Link, router } from "@inertiajs/react";
import { Button } from "@/components/ui/button";
import { FormEventHandler } from "react";
import { handlingZodInputError } from "@/lib/utils/handlingInputError";

import { z } from "zod";

export default function Edit() {
    const page = usePage();
    const userCourse = page.props.data as UserCourse;
    const status = page.props.statusFields as string[];
    console.log(userCourse);

    const { data, setData, put, processing, errors, reset } = useForm<
        z.infer<typeof UserCourseSchema.UPDATE>
    >({
        resolver: zodResolver(UserCourseSchema.UPDATE),
        status: userCourse.status,
    });

    function formatDate(date: string) {
        const d = new Date(date);
        return d.toLocaleDateString("id-ID", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
        });
    }

    function getCalcTotal() {
        return (
            userCourse.course.cost -
            (userCourse.course.disc * userCourse.course.cost) / 100
        );
    }

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        const dataParse = UserCourseSchema.UPDATE.safeParse(data);

        if (dataParse.success) {
            put(route("admin.invoice.update", { invoice: userCourse.id }), {
                onFinish: () => {
                    reset();
                },
            });
        } else {
            handlingZodInputError(dataParse, errors);
            router.reload();
        }
    };

    return (
        <AdminLayout
            header={
                <div>
                    <h1 className="text-2xl font-semibold leading-[1.8rem]">
                        Manage Detail Transaksi
                    </h1>
                    <p className="text-sm leading-[1.05rem] text-gray-400">
                        Ubah status transaksi.
                    </p>
                </div>
            }
        >
            <Head title="Manage Detail Transaction" />
            <div className="mb-10 py-4 border-t flex gap-12">
                <div className="grow">
                    <div className="flex items-stretch gap-3 mb-6">
                        <img
                            className="max-w-96 max-h-52 object-cover rounded-lg"
                            src={"/storage/" + userCourse.course.thumbnail}
                            alt=""
                        />
                        <div className="text font-medium text-sm py-4">
                            <h4 className="mb-4">{userCourse.status}</h4>
                            <h1 className="text-3xl mb-1">
                                {userCourse.course.title}
                            </h1>
                            <p className="text-gray-400">
                                {userCourse.course.desc}
                            </p>
                        </div>
                    </div>
                    <div>
                        <h1 className="text-2xl font-medium mb-3">Invoice</h1>
                        <div className="flex flex-col gap-3">
                            <div className="grid grid-cols-2 border-b justify-between pb-6 capitalize">
                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Tipe Kelas
                                    </h2>
                                    <h1 className="font-medium">
                                        {userCourse.course.course_type}
                                    </h1>
                                </div>
                                {userCourse.course.class && (
                                    <div>
                                        <h2 className="text-sm text-gray-400 mb-2">
                                            Jenis Kelas
                                        </h2>
                                        <h1 className="font-medium">
                                            {userCourse.course.class}
                                        </h1>
                                    </div>
                                )}
                            </div>
                            <div className="grid grid-cols-2 border-b pb-6 capitalize">
                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Nama Pembeli
                                    </h2>
                                    <h1 className="font-medium">
                                        {userCourse.children.user.name}
                                    </h1>
                                </div>

                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Nama Anak
                                    </h2>
                                    <h1 className="font-medium">
                                        {userCourse.children.name}
                                    </h1>
                                </div>
                            </div>
                            <div className="grid grid-cols-2 border-b pb-6 capitalize">
                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Mentor
                                    </h2>
                                    <h1 className="font-medium">
                                        {userCourse.course.mentor.name}
                                    </h1>
                                </div>
                            </div>
                            <div className="border-b pb-6 capitalize">
                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Hari
                                    </h2>
                                    <div className="flex gap-4">
                                        {userCourse.course.schedule.day
                                            .split(",")
                                            .map((day, index) => (
                                                <div
                                                    className="bg-primary/20 text-primary px-4 py-2 rounded-full"
                                                    key={index}
                                                >
                                                    {day}
                                                </div>
                                            ))}
                                    </div>
                                </div>
                            </div>
                            <div className="grid grid-cols-2 border-b pb-6 capitalize">
                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Waktu Mulai
                                    </h2>
                                    <h1 className="font-medium">
                                        {formatDate(
                                            userCourse.course.schedule
                                                .start_date
                                        )}
                                    </h1>
                                </div>

                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Waktu Akhir
                                    </h2>
                                    <h1 className="font-medium">
                                        {formatDate(
                                            userCourse.course.schedule.end_date
                                        )}
                                    </h1>
                                </div>
                            </div>
                            <div className="bg-primary/10 py-4 rounded-lg text-gray-500 font-medium">
                                <div className="px-4 border-b pb-6 border-primary/20 space-y-1">
                                    <div className="flex justify-between">
                                        <h4>Harga Kelas</h4>
                                        <h3 className="text-black">
                                            IDR. {userCourse.course.cost}
                                        </h3>
                                    </div>
                                    <div className="flex justify-between text-green-700">
                                        <h4>Diskon</h4>
                                        <h3>IDR. {userCourse.course.disc}</h3>
                                    </div>
                                </div>
                                <div className="py-2">
                                    <div className="flex justify-between px-4">
                                        <h4>Total</h4>
                                        <h3 className="text-primary">
                                            IDR. {getCalcTotal()}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="bg-[#FBFBFB] p-4 rounded-lg">
                    <form
                        onSubmit={submit}
                        className="flex flex-col h-full justify-between"
                    >
                        <div className="w-full">
                            <Label>Status</Label>
                            <RadioGroup
                                value={data.status}
                                className="grid grid-cols-2 w-full gap-2"
                            >
                                {status.map((element) => (
                                    <div
                                        key={element}
                                        className={`rounded-full focus:border-primary flex items-center space-x-2 w-full border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground px-5 py-3 ${
                                            data.status === element
                                                ? "border-primary text-primary bg-primary-foreground"
                                                : ""
                                        }`}
                                    >
                                        <RadioGroupItem
                                            onClick={() =>
                                                setData("status", element)
                                            }
                                            value={element}
                                            id={element}
                                        />
                                        <Label htmlFor={element}>
                                            {element.charAt(0).toUpperCase() +
                                                element.slice(1)}
                                        </Label>
                                    </div>
                                ))}
                            </RadioGroup>
                        </div>
                        <div className="flex justify-evenly">
                            <Button
                                type="button"
                                variant="outline"
                                onClick={() =>
                                    router.visit(route("admin.mentor.index"))
                                }
                            >
                                Batal aja deh
                            </Button>
                            <Button disabled={processing}>
                                Update Transaksi
                            </Button>
                        </div>
                    </form>
                </div>
            </div>
        </AdminLayout>
    );
}
