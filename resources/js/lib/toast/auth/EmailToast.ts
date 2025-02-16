import { toast } from "@/hooks/use-toast";

export function emailSentToast() {
    toast({
        title: "Verification Email Sent",
        description:
            "Tautan verifikasi baru telah dikirim ke email yang Anda berikan saat pendaftaran.",
    });
}

export function emailVerifiedToast() {
    toast({
        title: "Email has been Verified",
        description: "Complete your profile to finish registration.",
    });
}
