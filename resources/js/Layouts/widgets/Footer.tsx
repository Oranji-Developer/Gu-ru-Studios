import React from "react";
import ApplicationLogo from "@/components/ApplicationLogo";

import { contacts } from "@/lib/data/contacts";

export const Footer = () => {
    return (
        <footer className=" bg-[#FBF4FF] mt-16 max-w-8xl mx-auto pt-16 px-4 sm:px-6 lg:px-16 divide-y divide-[#B386CA]">
            <section className="flex justify-between items-stretch mb-[5.5rem]">
                <div className="company-information flex flex-col justify-between">
                    <ApplicationLogo />
                    <div className="margin-auto">
                        <h1>{contacts.email}</h1>
                        <h3>{contacts.phone}</h3>
                    </div>
                </div>
                <div className="flex gap-[5.5rem]">
                    <div>
                        <h2 className="font-medium mb-[1.12rem]">Company</h2>
                        <ul className="space-y-2">
                            <li>About Us</li>
                            <li>Blog</li>
                        </ul>
                    </div>
                    <div>
                        <h2 className="font-medium mb-[1.12rem]">Resources</h2>
                        <ul className="space-y-2">
                            <li>Documentation</li>
                            <li>Papers</li>
                            <li>Press Conferences</li>
                        </ul>
                    </div>
                    <div>
                        <h2 className="font-medium mb-[1.12rem]">Legal</h2>
                        <ul className="space-y-2">
                            <li>Terms of Service</li>
                            <li>Privacy Policy</li>
                            <li>Cookies Policy</li>
                        </ul>
                    </div>
                </div>
            </section>
            <div className="py-12 flex justify-between items-center">
                <h6 className="text-sm ">
                    &copy; {contacts.updatedAt} {contacts.name}.
                </h6>
                <div className="flex gap-4">
                    <a href={contacts.socials.facebook} className="mr-4">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M22 16.19C22 19.83 19.83 22 16.19 22H15C14.45 22 14 21.55 14 21V15.23C14 14.96 14.22 14.73 14.49 14.73L16.25 14.7C16.39 14.69 16.51 14.59 16.54 14.45L16.89 12.54C16.92 12.36 16.78 12.19 16.59 12.19L14.46 12.22C14.18 12.22 13.96 12 13.95 11.73L13.91 9.28C13.91 9.12 14.04 8.98001 14.21 8.98001L16.61 8.94C16.78 8.94 16.91 8.81001 16.91 8.64001L16.87 6.23999C16.87 6.06999 16.74 5.94 16.57 5.94L13.87 5.98001C12.21 6.01001 10.89 7.37 10.92 9.03L10.97 11.78C10.98 12.06 10.76 12.28 10.48 12.29L9.28 12.31C9.11 12.31 8.98001 12.44 8.98001 12.61L9.01001 14.51C9.01001 14.68 9.14 14.81 9.31 14.81L10.51 14.79C10.79 14.79 11.01 15.01 11.02 15.28L11.11 20.98C11.12 21.54 10.67 22 10.11 22H7.81C4.17 22 2 19.83 2 16.18V7.81C2 4.17 4.17 2 7.81 2H16.19C19.83 2 22 4.17 22 7.81V16.19Z"
                                fill="#9A5EB9"
                            />
                        </svg>
                    </a>
                    <a href={contacts.socials.x} className="mr-4">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M23.0308 7.28105L20.2277 10.0842C19.6614 16.6485 14.1255 21.7504 7.50017 21.7504C6.13892 21.7504 5.01673 21.5348 4.16454 21.1092C3.47736 20.7651 3.19611 20.3967 3.12579 20.2917C3.0631 20.1977 3.02246 20.0907 3.00692 19.9787C2.99138 19.8668 3.00133 19.7528 3.03604 19.6453C3.07075 19.5377 3.12931 19.4394 3.20735 19.3577C3.2854 19.2759 3.3809 19.2129 3.48673 19.1732C3.51111 19.1639 5.75923 18.3004 7.18704 16.657C6.39522 16.006 5.70399 15.2414 5.13579 14.3882C3.97329 12.6623 2.67204 9.66417 3.07329 5.18386C3.08601 5.0415 3.13915 4.90573 3.22644 4.79256C3.31373 4.67938 3.43154 4.5935 3.566 4.54503C3.70047 4.49657 3.84598 4.48753 3.9854 4.51899C4.12483 4.55045 4.25236 4.6211 4.35298 4.72261C4.38579 4.75542 7.47298 7.82574 11.2474 8.82136V8.25042C11.2459 7.65173 11.3643 7.0588 11.5955 6.50655C11.8267 5.9543 12.1661 5.4539 12.5936 5.0348C13.0088 4.62017 13.5029 4.2929 14.0466 4.07231C14.5904 3.85172 15.1728 3.74227 15.7595 3.75042C16.5466 3.75819 17.3183 3.96947 17.9996 4.36374C18.6808 4.75801 19.2485 5.32184 19.6474 6.00042H22.5002C22.6486 6.00031 22.7937 6.04423 22.9172 6.12663C23.0406 6.20904 23.1368 6.32621 23.1936 6.46333C23.2505 6.60045 23.2653 6.75134 23.2363 6.8969C23.2073 7.04247 23.1358 7.17616 23.0308 7.28105Z"
                                fill="#9A5EB9"
                            />
                        </svg>
                    </a>
                    <a href={contacts.socials.instagram} className="mr-4">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M16.19 2H7.81C4.17 2 2 4.17 2 7.81V16.18C2 19.83 4.17 22 7.81 22H16.18C19.82 22 21.99 19.83 21.99 16.19V7.81C22 4.17 19.83 2 16.19 2ZM12 15.88C9.86 15.88 8.12 14.14 8.12 12C8.12 9.86 9.86 8.12 12 8.12C14.14 8.12 15.88 9.86 15.88 12C15.88 14.14 14.14 15.88 12 15.88ZM17.92 6.88C17.87 7 17.8 7.11 17.71 7.21C17.61 7.3 17.5 7.37 17.38 7.42C17.26 7.47 17.13 7.5 17 7.5C16.73 7.5 16.48 7.4 16.29 7.21C16.2 7.11 16.13 7 16.08 6.88C16.03 6.76 16 6.63 16 6.5C16 6.37 16.03 6.24 16.08 6.12C16.13 5.99 16.2 5.89 16.29 5.79C16.52 5.56 16.87 5.45 17.19 5.52C17.26 5.53 17.32 5.55 17.38 5.58C17.44 5.6 17.5 5.63 17.56 5.67C17.61 5.7 17.66 5.75 17.71 5.79C17.8 5.89 17.87 5.99 17.92 6.12C17.97 6.24 18 6.37 18 6.5C18 6.63 17.97 6.76 17.92 6.88Z"
                                fill="#9A5EB9"
                            />
                        </svg>
                    </a>
                </div>
            </div>
        </footer>
    );
};
