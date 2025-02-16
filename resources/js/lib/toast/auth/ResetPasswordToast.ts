import { toast } from "@/hooks/use-toast";

export function passwordResetRequestToast() {
    toast({
        title: "Password Reset Email Sent",
        description:
            "We have e-mailed your password reset link! Please check your inbox.",
    });
}

export function passwordResetToast() {
    toast({
        variant: "primary",
        title: "Password Reset Success",
        description: "Your password has been successfully reset.",
    });
}
