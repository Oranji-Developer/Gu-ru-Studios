import { CustomerLayout } from "@/Layouts/CustomerLayout";
import { Course } from "@/types/model/Course";
import { Button } from "@/components/ui/button";
import { usePage, router, Head, Link } from "@inertiajs/react";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import React from "react";
import { format } from "date-fns";
import { Schedule } from "@/types/model/Schedule";
import { UserCourse } from "@/types/model/UserCourse";
import { Testimonies } from "@/types/model/Testimonies";
import { StarIcon } from "@heroicons/react/24/solid";
import { Textarea } from "@/components/ui/textarea";
import { useForm } from "@inertiajs/react";
import { z } from "zod";
import { TestimonieSchema } from "@/lib/schema/TestimonieSchema";
import { StarRating } from "@/components/StarRating";
import { FormEventHandler } from "react";
import InputError from "@/components/InputError";
import { handlingZodInputError } from "@/lib/utils/handlingInputError";
import { ModalChildren } from "./widgets/ModalChildren";

export default function Detail() {
    const page = usePage();

    const course = page.props.course as Course & {
        user_course: (UserCourse & { testimonies: Testimonies })[];
    };

    const schedule = course.schedule as Schedule;
    let userCourseId: (UserCourse & { testimonies: Testimonies }) | undefined;
    if (page.props.auth.user != null) {
        userCourseId = course.user_course.find(
            (userCourse) =>
                userCourse.children.user_id == page.props.auth.user.id
        );
    }

    // const userCourseId = course.user_course.find(
    //     (userCourse) => userCourse.children.user_id == page.props.auth.user.id
    // );

    const { data, setData, post, processing, errors } = useForm<
        z.infer<typeof TestimonieSchema.CREATE>
    >({
        userCourse_id: userCourseId?.id,
        desc: userCourseId?.testimonies?.desc ?? "",
        rating: userCourseId?.testimonies?.rating ?? 0,
    });

    const submit: FormEventHandler = async (e) => {
        e.preventDefault();

        const userCourseId = course.user_course.find(
            (userCourse) =>
                userCourse.children.user_id == page.props.auth.user.id
        );

        if (userCourseId) {
            let dataParse = TestimonieSchema.UPDATE.safeParse(data);

            let urlAction = "";
            let dataSend;
            if (userCourseId.testimonies != null) {
                dataSend = { ...data, _method: "PUT" };
                urlAction = "user.testimony.update";
            } else {
                dataSend = { ...data };
                urlAction = "user.testimony.store";
            }

            if (dataParse.success) {
                router.post(
                    route(urlAction, {
                        testimony: userCourseId.testimonies.id,
                    }),
                    { ...dataSend },
                    {
                        preserveState: true,
                        replace: true,
                        only: ["course"],
                    }
                );
            } else {
                handlingZodInputError(dataParse, errors);
                router.reload();
            }
        }
    };

    function formatDate(date: string) {
        return format(new Date(date), "MMMM do,yyyy");
    }

    function formatTime(time: string) {
        const now = new Date();
        now.setHours(parseInt(time.split(":")[0]));
        now.setMinutes(parseInt(time.split(":")[1]));
        return format(now, "HH:mm");
    }

    function downloadCV() {
        fetch("storage/" + course.mentor.cv).then((response) => {
            response.blob().then((blob) => {
                // Creating new object of PDF file
                const fileURL = window.URL.createObjectURL(blob);

                // Setting various property values
                let alink = document.createElement("a");
                alink.href = fileURL;
                alink.download = "CV_" + course.mentor.name + ".pdf";
                alink.click();
            });
        });
    }

    return (
        <CustomerLayout>
            <Head title="Book Course" />
            <section className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h1 className="text-5xl font-semibold mb-3">
                        {course.title}
                    </h1>
                    <p className="text-2xl text-gray-500">{course.desc}</p>
                    <h2 className="text-[2.5rem] py-6 text-primary font-semibold">
                        IDR. {course.cost}
                    </h2>
                    <div className="flex gap-6">
                        <ModalChildren></ModalChildren>
                        <Button
                            variant={"outline"}
                            className="text-primary border-primary/60"
                        >
                            Jadwal Kelas
                        </Button>
                    </div>
                </div>
                <div>
                    <img
                        className="rounded-xl w-[41.25rem] h-[23.25rem] object-cover"
                        src={"/storage/" + course.thumbnail}
                        alt=""
                    />
                </div>
            </section>
            <section className="flex flex-col">
                <div className="profile-information flex items-center gap-3">
                    <Avatar className="w-24 h-24">
                        <AvatarImage src={course.mentor.profile_picture} />
                        <AvatarFallback className="text-2xl">
                            {course.mentor.name.slice(0, 4)}
                        </AvatarFallback>
                    </Avatar>
                    <div className="text-2xl">
                        <h1 className=" font-semibold">{course.mentor.name}</h1>
                        <p className="text-gray-500">{course.mentor.phone}</p>
                    </div>
                </div>
                <div className="text-2xl py-6">
                    <p className="">{course.mentor.desc}</p>
                </div>

                <Button type="button" onClick={downloadCV} className="self-end">
                    Lihat CV
                </Button>
            </section>
            <section className="py-16">
                <h1 className="text-2xl font-medium mb-3">Jadwal Kelas</h1>
                <h2 className="text-4xl font-semibold mb-8">
                    Lihat jadwal kelas dan sesuaikan dengan
                </h2>

                <div className="py-8 px-6 bg-gray-50 rounded-xl border border-gray-300">
                    <h1 className="text-2xl font-medium mb-3">
                        {formatDate(schedule.start_date)} -{" "}
                        {formatDate(schedule.end_date)}
                    </h1>
                    <h2 className="text-xl font-medium mb-6">
                        {formatTime(schedule.start_time)} -{" "}
                        {formatTime(schedule.end_time)}
                    </h2>
                    <div className="flex gap-2">
                        {schedule.day.split(",").map((day, index) => (
                            <div
                                key={index}
                                className="py-2 px-8 bg-primary/10 border border-primary w-fit rounded-full"
                            >
                                {day}
                            </div>
                        ))}
                    </div>
                </div>
            </section>
            <section>
                <div className="text-center">
                    <h1 className="text-2xl font-medium text-gray-500">
                        Testimoni
                    </h1>
                    <h2 className="text-[2rem] font-semibold">
                        Pengalaman Klien yang Transformatif
                    </h2>
                </div>
                <div className="py-8">
                    {course.user_course.length == 0 ? (
                        <h1 className="text-center py-4 px-2">
                            Belum ada testimonie
                        </h1>
                    ) : null}
                    <div className="grid grid-cols-3 gap-3">
                        {course.user_course.map((testimony, index) =>
                            // if the testimoney is null then return null
                            testimony.testimonies != null ? (
                                <div
                                    key={index}
                                    className="p-4 border rounded-lg mb-4 flex flex-col h-full justify-between"
                                >
                                    <div className="flex flex-col gap-2">
                                        <span className="text-2xl font-medium">
                                            "
                                        </span>
                                        <div className="flex gap-1 text-yellow-400">
                                            {Array.from({
                                                length: testimony.testimonies
                                                    .rating,
                                            }).map((_, index) => (
                                                <StarIcon
                                                    key={index}
                                                    className="w-5"
                                                />
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
                            ) : null
                        )}
                    </div>
                </div>
                {userCourseId ? (
                    <form onSubmit={submit}>
                        <div className="flex flex-col gap-3">
                            <h1 className="text-2xl font-medium">
                                Tulis Reviewmu
                            </h1>
                            <div className="flex gap-2 py-2">
                                <StarRating
                                    initialRating={data.rating}
                                    onRatingChange={(e) =>
                                        setData("rating", e.toString())
                                    }
                                />
                                <InputError
                                    message={errors.rating}
                                    className="mt-2"
                                />
                            </div>
                            <div>
                                <Textarea
                                    value={data.desc}
                                    onChange={(e) =>
                                        setData("desc", e.target.value)
                                    }
                                />

                                <InputError
                                    message={errors.desc}
                                    className="mt-2"
                                />
                            </div>

                            <Button
                                disabled={processing}
                                className="self-end px-8"
                            >
                                {userCourseId ? "Update Review" : "Kirim"}
                            </Button>
                        </div>
                    </form>
                ) : null}
            </section>
        </CustomerLayout>
    );
}
