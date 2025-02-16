import { CustomerLayout } from "@/Layouts/CustomerLayout";
import { Children } from "@/types/model/Children";
import { Course } from "@/types/model/Course";
import { usePage } from "@inertiajs/react";
import React from "react";
import { FormEventHandler } from "react";
import { Button } from "@/components/ui/button";
import { useForm } from "@inertiajs/react";
import { z } from "zod";
import { UserCourseSchema } from "@/lib/schema/UserCourseSchema";

export default function Invoice() {
    const page = usePage().props;

    const course = page.course as Course;
    const children = page.children as Children;

    const { data, setData, post, processing, errors } = useForm<
        z.infer<typeof UserCourseSchema.CREATE>
    >({
        children_id: children.id,
        course_id: course.id,
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
        return course.cost - (course.disc * course.cost) / 100;
    }

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route("user.course.store"));

        console.log("submit");
    };

    return (
        <CustomerLayout>
            <div className="mb-6">
                <div className="flex items-stretch gap-3 mb-6">
                    <img
                        className="max-w-96 max-h-52 object-cover rounded-lg"
                        src={"/storage/" + course.thumbnail}
                        alt=""
                    />
                    <div className="text font-medium text-sm py-4">
                        <h1 className="text-3xl mb-1">{course.title}</h1>
                        <p className="text-gray-400">{course.desc}</p>
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
                                    {course.course_type}
                                </h1>
                            </div>
                            {course.class && (
                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Jenis Kelas
                                    </h2>
                                    <h1 className="font-medium">
                                        {course.class}
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
                                    {children.user.name}
                                </h1>
                            </div>

                            <div>
                                <h2 className="text-sm text-gray-400 mb-2">
                                    Nama Anak
                                </h2>
                                <h1 className="font-medium">{children.name}</h1>
                            </div>
                        </div>
                        <div className="grid grid-cols-2 border-b pb-6 capitalize">
                            <div>
                                <h2 className="text-sm text-gray-400 mb-2">
                                    Mentor
                                </h2>
                                <h1 className="font-medium">
                                    {course.mentor.name}
                                </h1>
                            </div>
                        </div>
                        <div className="border-b pb-6 capitalize">
                            <div>
                                <h2 className="text-sm text-gray-400 mb-2">
                                    Hari
                                </h2>
                                <div className="flex gap-4">
                                    {course.schedule.day
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
                                    {formatDate(course.schedule.start_date)}
                                </h1>
                            </div>

                            <div>
                                <h2 className="text-sm text-gray-400 mb-2">
                                    Waktu Akhir
                                </h2>
                                <h1 className="font-medium">
                                    {formatDate(course.schedule.end_date)}
                                </h1>
                            </div>
                        </div>
                        <div className="bg-primary/10 py-4 rounded-lg text-gray-500 font-medium">
                            <div className="px-4 border-b pb-6 border-primary/20 space-y-1">
                                <div className="flex justify-between">
                                    <h4>Harga Kelas</h4>
                                    <h3 className="text-black">
                                        IDR. {course.cost}
                                    </h3>
                                </div>
                                <div className="flex justify-between text-green-700">
                                    <h4>Diskon</h4>
                                    <h3>IDR. {course.disc}</h3>
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
            <form onSubmit={submit} className="flex justify-end gap-4">
                <Button
                    type="button"
                    variant="outline"
                    onClick={() => history.back()}
                >
                    Batal aja deh
                </Button>
                <Button type="submit" disabled={processing}>
                    Daftar Sekarang
                </Button>
            </form>
        </CustomerLayout>
    );
}
