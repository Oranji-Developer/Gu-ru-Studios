import { AdminLayout } from "@/Layouts/AdminLayout";
import { Course } from "@/types/model/Course";
import { usePage, Head } from "@inertiajs/react";
import {
    UserGroupIcon,
    PencilIcon,
    CalendarDaysIcon,
    StarIcon,
} from "@heroicons/react/24/solid";
import React from "react";
import { UserCourse } from "@/types/model/UserCourse";
import { Testimonies } from "@/types/model/Testimonies";

export default function Show() {
    const page = usePage();

    const courseDetail = page.props.course as Course & {
        user_course: (UserCourse & { testimonies: Testimonies })[];
    };

    console.log(page.props);

    function formatDate(date: string) {
        const d = new Date(date);
        return d.toLocaleDateString("id-ID", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
        });
    }

    return (
        <AdminLayout
            header={
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-2xl font-semibold leading-[1.8rem]">
                            Detail Course
                        </h1>
                        <p className="text-sm leading-[1.05rem] text-gray-400">
                            Information detail about{" "}
                            <span className="text-primary/80">
                                {courseDetail.title}
                            </span>
                        </p>
                    </div>
                </div>
            }
        >
            <Head title="Detail Course" />
            <div className="mb-10 py-4 border-t flex gap-12">
                <div className="grow">
                    <div className="flex items-stretch gap-3 mb-6">
                        <img
                            className="max-w-96 max-h-52 object-cover rounded-lg"
                            src={"/storage/" + courseDetail.thumbnail}
                            alt=""
                        />
                        <div className="text font-medium text-sm py-4">
                            <h4 className="mb-4">{courseDetail.status}</h4>
                            <h1 className="text-3xl mb-1">
                                {courseDetail.title}
                            </h1>
                            <p className="text-gray-400">{courseDetail.desc}</p>
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
                                        {courseDetail.course_type}
                                    </h1>
                                </div>
                                {courseDetail.class && (
                                    <div>
                                        <h2 className="text-sm text-gray-400 mb-2">
                                            Jenis Kelas
                                        </h2>
                                        <h1 className="font-medium">
                                            {courseDetail.class}
                                        </h1>
                                    </div>
                                )}
                            </div>

                            <div className="grid grid-cols-2 border-b pb-6 capitalize">
                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Mentor
                                    </h2>
                                    <h1 className="font-medium">
                                        {courseDetail.mentor.name}
                                    </h1>
                                </div>
                            </div>
                            <div className="border-b pb-6 capitalize">
                                <div>
                                    <div className="flex gap-2 items-center mb-3">
                                        <CalendarDaysIcon className="w-5" />
                                        <h2>Jadwal</h2>
                                    </div>
                                    <div className="flex gap-4">
                                        {courseDetail.schedule.day
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
                                            courseDetail.schedule.start_date
                                        )}
                                    </h1>
                                </div>

                                <div>
                                    <h2 className="text-sm text-gray-400 mb-2">
                                        Waktu Akhir
                                    </h2>
                                    <h1 className="font-medium">
                                        {formatDate(
                                            courseDetail.schedule.end_date
                                        )}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="bg-[#FBFBFB] rounded-lg px-4 py-3 w-96">
                    <div className="flex gap-2 pb-3 mb-3 border-b">
                        <UserGroupIcon className="w-5" /> <span>Siswa</span>
                    </div>
                    <div className="grid grid-cols-1 gap-3">
                        {courseDetail.user_course.map(
                            (user_course, index: number) => (
                                <div
                                    key={index}
                                    className=" py-2 px-3 rounded-lg border flex flex-col "
                                >
                                    <h2 className="">
                                        Anak: {user_course.children.name}
                                    </h2>
                                    <h2 className="text-nowrap">
                                        Ortu: {user_course.children.user.name}
                                    </h2>
                                    <h2 className="self-end text-sm font-medium text-gray-500/70">
                                        {formatDate(user_course.start_date)}
                                    </h2>
                                </div>
                            )
                        )}
                    </div>
                </div>
            </div>
            <div>
                <div className="flex gap-2 pb-3 mb-3 border-b">
                    <PencilIcon className="w-5" /> <span>Testimoni</span>
                </div>
                <div className="grid grid-cols-3 gap-3">
                    {courseDetail.user_course.map((testimony, index) => (
                        <div
                            key={index}
                            className="p-4 border rounded-lg mb-4 flex flex-col h-full justify-between"
                        >
                            <div className="flex flex-col gap-2">
                                <span className="text-2xl font-medium">"</span>
                                <div className="flex gap-1 text-yellow-400">
                                    {Array.from({
                                        length: testimony.testimonies.rating,
                                    }).map((_, index) => (
                                        <StarIcon key={index} className="w-5" />
                                    ))}
                                </div>
                                <p className="w-2/3 text-2xl font-bold leading-tight">
                                    {testimony.testimonies.desc}
                                </p>
                            </div>
                            <h2 className="text-lg font-medium text-gray-600">
                                {testimony.children.user.name}
                            </h2>
                        </div>
                    ))}
                </div>
            </div>
        </AdminLayout>
    );
}
