import React from "react";
import { Button } from "@/components/ui/button";
import { ArrowUpRightIcon } from "@heroicons/react/24/solid";

export const Hero = () => {
    return (
        <>
            <>
                <img
                    src="/images/bg-landing.png"
                    className="absolute inset-0 -z-50 h-[50rem] w-full object-cover opacity-30"
                ></img>
                <div className="absolute inset-0 -z-50 mix-blend-multiply">
                    <div className="h-[25rem] w-full bg-gradient-to-b from-white/0 from-30% to-[#EECCFF]/80 to-90%" />
                    <div className="h-[25rem] w-full bg-gradient-to-b from-[#EECCFF]/80 from-50% to-white/0 to-85%" />
                </div>
                <div className="absolute -z-50 inset-0 mix-blend-overlay">
                    <div className="h-[25rem] w-full bg-gradient-to-b from-white/100 from-0% to-white/0 to-30%" />
                    <div className="h-[25rem] w-full bg-gradient-to-b from-white/0 from-70% to-white/100 to-90%" />
                </div>
            </>
            <section className="grid grid-cols-2 mt-14">
                <div className="max-w-[35.5rem] space-y-6">
                    <h3 className="text-2xl bg-primary py-3 px-7 w-fit rounded-full font-medium text-white">
                        #1 Course Malang
                    </h3>
                    <div className="space-y-2">
                        <h1 className="text-[3.25rem] font-semibold leading-tight">
                            Belajar Tanpa Ribet, Pilih Jadwal dan Mentor
                            Favoritmu!
                        </h1>
                        <p className="text-2xl font-medium leading-[120%] text-neutral-500">
                            Kami sudah menyiapkan jadwal, mentor, dan tempat
                            terbaik. Anda hanya perlu memilih sesuai kebutuhan
                            Anda.
                        </p>
                    </div>
                    <div className="flex gap-3">
                        <Button type="button">Daftar Sekarang</Button>
                        <Button type="button" variant="secondary">
                            Lihat Kelas
                        </Button>
                    </div>
                </div>
                <div className="relative">
                    <div className="absolute w-fit translate-y-1/2 bottom-0 top-28 left-[116px] translate-x-1/2 z-10">
                        <h1 className="text-2xl font-medium rounded-full px-5 py-3 bg-primary text-white">
                            gurustudio
                        </h1>
                    </div>
                    <div className="flex gap-5 flex-wrap ">
                        <div className="relative">
                            <div className="relative w-fit">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="302"
                                    height="340"
                                    viewBox="0 0 302 340"
                                    fill="none"
                                >
                                    <path
                                        d="M302 58.6425C302 53.0455 296.596 49 291 49C268.356 49 250 30.6437 250 8C250 3.83178 246.897 0 242.729 0L29.9995 0C13.431 0 -0.000488281 13.4315 -0.000488281 30V310C-0.000488281 326.569 13.431 340 29.9995 340H272C288.568 340 302 326.569 302 310V58.6425Z"
                                        fill="#801209"
                                    />
                                </svg>
                                <div className=" bg-[#801209] p-[1.38rem] w-fit rounded-full absolute -right-7 -top-7">
                                    <ArrowUpRightIcon className="w-6 text-white" />
                                </div>
                                <img
                                    src="/images/elementary-student.png"
                                    alt=""
                                    className="absolute bottom-0"
                                />
                            </div>
                        </div>
                        <div className="relative top-[84px]">
                            <div className="relative w-fit">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="312"
                                    height="306"
                                    viewBox="0 0 312 306"
                                    fill="none"
                                >
                                    <path
                                        d="M30.9934 0C13.8762 0 0 13.4315 0 30V251C0 254.866 3.23778 258 7.23179 258C24.349 258 38.2252 271.431 38.2252 288V303C38.2252 304.609 39.514 306 41.1765 306H281.007C298.124 306 312 292.569 312 276V30C312 13.4315 298.124 0 281.007 0H30.9934Z"
                                        fill="#680D96"
                                    />
                                    <path
                                        d="M30.9934 0C13.8762 0 0 13.4315 0 30V251C0 254.866 3.23778 258 7.23179 258C24.349 258 38.2252 271.431 38.2252 288V303C38.2252 304.609 39.514 306 41.1765 306H281.007C298.124 306 312 292.569 312 276V30C312 13.4315 298.124 0 281.007 0H30.9934Z"
                                        fill="url(#pattern0_1)"
                                    />
                                    <defs>
                                        <pattern
                                            id="pattern0_1"
                                            patternContentUnits="userSpaceOnUse"
                                            width="1"
                                            height="1"
                                            className="object-cover bg-no-repeat"
                                        >
                                            <image
                                                id="image0_126_628"
                                                className="object-cover w-full h-full "
                                                href="/images/teacher.png"
                                            />
                                        </pattern>
                                    </defs>
                                </svg>
                                <img
                                    src="/images/teacher-head.png"
                                    alt=""
                                    className="absolute -top-11 right-[10px]"
                                />
                            </div>
                        </div>
                        <div className="relative -left-[69px]">
                            <div className="relative w-fit">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="362"
                                    height="241"
                                    viewBox="0 0 362 241"
                                    fill="none"
                                >
                                    <path
                                        d="M235 30C235 13.4315 221.568 0 205 0H29.9995C13.431 0 -0.000488281 13.4315 -0.000488281 30V211C-0.000488281 227.569 13.431 241 29.9995 241H332C348.568 241 362 227.569 362 211V102C362 85.4315 348.568 72 332 72H265C248.431 72 235 58.5685 235 42V30Z"
                                        fill="#DE9D70"
                                    />
                                </svg>
                                <img
                                    src="/images/elementary-student-female.png"
                                    alt=""
                                    className="absolute bottom-0 left-6"
                                />
                            </div>
                        </div>
                        <div className="relative -left-12 z-20 top-7 flex items-center justify-end">
                            <div className="text-center px-14 py-10 border-4 backdrop-blur-sm border-purple-100 rounded-[2rem]">
                                <h1 className="text-5xl text-primary font-medium">
                                    10K+
                                </h1>
                                <p className="text-gray-500">
                                    The number of students
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};
